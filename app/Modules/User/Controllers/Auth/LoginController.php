<?php

namespace App\Modules\User\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Modules\Notification\Message\UserSMSMessage;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\User\Entity\User;
use App\Modules\User\Repository\UserRepository;
use App\Modules\User\Service\RegisterService;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    use ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    private RegisterService $service;
    private \App\Modules\Setting\Entity\Web $web;
    private UserRepository $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(RegisterService $service, SettingRepository $settings, UserRepository $repository)
    {
        $this->web = $settings->getWeb();
        $this->middleware('guest')->except('logout');
        //$this->middleware('guest:admin')->except('logout');
        $this->service = $service;
        $this->repository = $repository;
    }

    public function redirectPath(): string
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    public function showLoginForm(): View
    {
        if (!$this->web->auth) abort(404);
        return view('user.auth.login'); //Своя форма аутентификации
    }
/*
    public function login_ajax()
    {
        if (!$this->web->auth) throw new \DomainException('Аутентификация невозможна');
        $result = view('user.auth.login-popup')->render();
        return \response()->json($result);
        //Своя форма аутентификации
    }
*/
    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return Response
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        if (!$this->web->auth) abort(404);
        return;
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $intended = empty($request['intended']) ? '****' : $request['intended'];
        $authenticate = $this->guard()->attempt(
            $request->only(['email', 'password']),
            true//$request->filled('remember')
        );

        if ($authenticate) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);

            flash($intended, 'danger');
            return redirect($intended);//->intended($request['intended'] ?? '');
        }
        $this->incrementLoginAttempts($request);
        throw ValidationException::withMessages(['email' => [trans('auth.failed')]]);
    }

    /**
     * Аутентификация или Регистрация по email или phone
     * @param Request $request
     * @return JsonResponse
     */

    public function login_registration(Request $request)
    {
        if (!$this->web->auth) abort(404);

        if (!empty($verify_token = $request['verify_token'])) {
            if (!$user = User::where('verify_token', $verify_token)->first())
                return \response()->json(['token' => true]); //Неверный токен
            $this->service->verify($user->id);
            $this->authenticate($request);
            return \response()->json(['login' => true]);
        } else {
            $user = $this->repository->findEmailOrPhone($request['phone'], $request['email']);//Проверяем Зарегистрирован или нет
        }

        if (empty($user)) {
            try {
                $this->service->register($request);
                return \response()->json(['register' => true]);
            } catch (\Throwable $e) {
                \response()->json(['error' => [$e->getMessage(), $e->getFile(), $e->getLine()]]);
            }
        }

        if ($this->authenticate($request)) {
            /** @var User $user */
            $user = Auth::user(); //Auth::guard('user')->user();

            if ($user->status != User::STATUS_ACTIVE) {
                Auth::logout();
                return \response()->json(['verification' => true]);
            }
            return \response()->json(['login' => true]);
        } else { //Неверный пароль
            return \response()->json(['password' => true]);
        }
    }

    private function authenticate(Request $request): bool
    {
        if ($this->web->auth_phone) {
            return $this->guard()->attempt($request->only(['phone', 'password']), true);
        } else {
            return $this->guard()->attempt($request->only(['email', 'password']), true);
        }
    }

    public function phone(Request $request)
    {

        $user = $this->repository->findEmailOrPhone($request['phone'], null);
        if (!empty($user)) {
            $password = Str::random(8);
            $user->setPassword($password);
            $user->notify(new UserSMSMessage('password: ' . $password));
            return \response()->json(true);
        } else {
               return \response()->json(['error' => 'Пользователь не найден']);
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @return Response
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        //if (Auth::guard('admin')->check()) throw new \DomainException('Пользователь Админ');
        //if (Auth::guard('user')->check()) $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    protected function guard(): StatefulGuard
    {
        return Auth::guard('user');
    }


    protected function authenticated(Request $request, $user)
    {
        if (!$user->status != User::STATUS_ACTIVE) {
            $this->guard()->logout();
            flash('Вы не подтвердили свой аккаунт', 'danger');
            return back();
        }
        return redirect()->intended($this->redirectPath());
    }

    protected function username(): string
    {
        return 'email';
    }

}
