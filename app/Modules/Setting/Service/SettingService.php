<?php

namespace App\Modules\Setting\Service;

use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Helpers\CacheHelper;
use App\Modules\Web\Helpers\Menu;
use Illuminate\Http\Request;
use App\Modules\Setting\Entity\Setting;
use Illuminate\Support\Facades\Cache;

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
        if ($slug == 'mail') $this->saveMailBoxes();
        if ($slug == 'web') $this->saveCache();
    }

    private function saveTelegramToken()
    {
        $notification = $this->repository->getNotification();
        $this->putPermanentEnv('TELEGRAM_BOT_TOKEN', $notification->telegram_api);
    }

    private function saveMailBoxes()
    {
        $mail = $this->repository->getMail();
        $this->putPermanentEnv('MAIL_OUTBOX_USERNAME', $mail->outbox_name . '@' . $mail->mail_domain);
        $this->putPermanentEnv('MAIL_OUTBOX_PASSWORD', $mail->outbox_password);
        $this->putPermanentEnv('MAIL_SYSTEM_USERNAME', $mail->system_name . '@' . $mail->mail_domain);
        $this->putPermanentEnv('MAIL_SYSTEM_PASSWORD', $mail->system_password);
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

    private function saveCache()
    {
        Cache::flush();//Очищаем весь кэш

        Cache::put(CacheHelper::MENU_TOP, Menu::menuTop()); //Сохраняем меню
    }
}
