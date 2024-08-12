<?php

namespace App\Modules\Setting\Service;

use App\Modules\Setting\Repository\SettingRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Setting\Entity\Setting;

class SettingService
{

    private SettingRepository $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(Request $request)
    {
        $slug = $request->string('slug')->value();
        /** @var Setting $setting */
        $setting = Setting::where('slug', $slug)->first();

        $data = $request->except(['slug']);
        $setting->data = $data;

        $setting->save();

        if ($slug == 'notification') $this->saveTelegramToken();
    }

    private function saveTelegramToken()
    {
        $notification = $this->repository->getNotification();
        $this->putPermanentEnv('TELEGRAM_BOT_TOKEN', $notification->telegram_api);
    }

    private function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('='.env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}
