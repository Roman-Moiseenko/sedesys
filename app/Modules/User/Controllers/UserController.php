<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Entity\User;
use App\Modules\User\Requests\UserRequest;
use App\Modules\User\Repository\UserRepository;
use App\Modules\User\Service\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{

    private UserService $service;
    private UserRepository $repository;

    public function __construct(UserService $service, UserRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $users = $this->repository->getIndex($request, $filters);

        return Inertia::render('User/User/Index', [
                'users' => $users,
                'filters' => $filters,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('User/User/Create', [
        ]);
    }

    public function store(UserRequest $request)
    {
        $request->validated();
        $user = $this->service->create($request);
        return redirect()
            ->route('admin.user.user.show', $user)
            ->with('success', 'Новый клиент добавлен');
    }

    public function show(User $user)
    {
        $user = User::where('id', $user->id)->with('oauths')->first();
        return Inertia::render('User/User/Show', [
                'user' => $user,
            ]
        );
    }

    public function edit(User $user)
    {
        return Inertia::render('User/User/Edit', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $request->validated();
        $this->service->update($user, $request);
        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.user.user.show', $user)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(User $user)
    {
        $this->service->destroy($user);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function verify(User $user)
    {
        $user->verify();
        return redirect()->back()->with('success', 'Пользователь верифицирован');
    }


    //Axios
    public function find_phone(Request $request)
    {
        try {
            $phone = $request->integer('phone');
            $users = User::where('phone', 'LIKE', "%$phone%")->get()->map(function (User $user) {
                return [
                    'value' => $user->id,
                    'label' => $user->phone,
                ];
            })->toArray();
            return response()->json($users);

        } catch (\Throwable $e) {
            return response()->json([$e->getMessage()]);
        }
    }

    //Работа с User
    public function find(Request $request)
    {
        $phone = $request->input('phone');
        if (is_null($user = User::where('phone', $phone)->first())) {
            return response()->json(false);
        } else {
            return response()->json($user);
        }
    }

    public function set(User $user, Request $request)
    {
        try {
            $this->service->update($user, $request);
            return redirect()->back()->with('success', 'Сохранено');
            //return response()->json(true);
        } catch (\DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
            //return response()->json($e->getMessage());
        }
    }
    /*
    public function add(Request $request)
    {
        $meassage = $this->service->create_fast($request);
        return redirect()->back()->with('success', $meassage);
    }*/
}
