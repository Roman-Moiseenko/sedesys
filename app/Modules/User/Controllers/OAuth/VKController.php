<?php
declare(strict_types=1);

namespace App\Modules\User\Controllers\OAuth;

use App\Http\Controllers\Controller;
use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\User\Entity\OAuth;
use App\Modules\User\Service\OAuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class VKController extends Controller
{
    private OAuthService $service;
    private Web $web;

    public function __construct(OAuthService $service, SettingRepository $settings)
    {
        $this->service = $service;
        $this->web = $settings->getWeb();
    }

    public function oauth()
    {
        if (!$this->web->auth) abort(404);
        return Socialite::driver(OAuth::VK)->redirect();
    }

    public function callback()
    {
        $vkUser = Socialite::driver(OAuth::VK)->user();
        $user = $this->service->findOrCreate($vkUser, OAuth::VK);
        Auth::login($user, true);

        return redirect()->route('web.home')->with('success', 'Добро пожаловать');
    }
}
