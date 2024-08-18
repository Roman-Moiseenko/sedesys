<?php
declare(strict_types=1);

namespace App\Modules\User\Controllers\OAuth;

use App\Http\Controllers\Controller;
use App\Modules\User\Entity\OAuth;
use App\Modules\User\Entity\User;
use App\Modules\User\Repository\UserRepository;
use App\Modules\User\Service\OAuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class YandexController extends Controller
{
    private OAuthService $service;

    public function __construct(OAuthService $service)
    {
        $this->service = $service;
    }

    public function oauth()
    {
        return Socialite::driver('yandex')->redirect();
    }

    public function callback()
    {
        $yandexUser = Socialite::driver('yandex')->user();
        Log::info(json_encode($yandexUser));

        $user = $this->service->findOrCreate($yandexUser, OAuth::YANDEX);

        Auth::login($user, true);

        redirect()->route('web');
    }
}
