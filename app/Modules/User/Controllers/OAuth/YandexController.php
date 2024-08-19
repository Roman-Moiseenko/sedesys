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

class YandexController extends Controller
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
        return Socialite::driver(OAuth::YANDEX)->redirect();
    }

    public function callback()
    {
        $yandexUser = Socialite::driver(OAuth::YANDEX)->user();
        Log::info(json_encode($yandexUser));

        $user = $this->service->findOrCreate($yandexUser, OAuth::YANDEX);

        Auth::login($user, true);

        redirect()->route('web.home');
    }
}
