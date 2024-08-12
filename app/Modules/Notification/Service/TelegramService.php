<?php
declare(strict_types=1);

namespace App\Modules\Notification\Service;

use App\Modules\Setting\Entity\Notification;
use App\Modules\Setting\Repository\SettingRepository;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;
use NotificationChannels\Telegram\TelegramUpdates;

class TelegramService
{

    private Notification $notification;

    public function __construct(SettingRepository $settings)
    {
        $this->notification = $settings->getNotification();
    }

    public function getListChatIds(): array
    {
        if (config('app.env') != 'local') $this->delWebHook();
        $updates = TelegramUpdates::create()->limit(2)
            ->options([
                'timeout' => 0,
            ])->get();
        $list = [];

        if($updates['ok']) {
            foreach ($updates['result'] as $user) {
                $list[] = [
                    'name' => $user['message']['chat']['first_name'],
                    'login' => $user['message']['chat']['username'],
                    'id' => $user['message']['chat']['id'],
                ];
            }
        }
        if (config('app.env') != 'local') $this->setWebHook();
        return $list;
    }


    public function setWebHook(): bool|string
    {
        $route = route('api.telegram.web-hook');

        $url = "https://api.telegram.org/bot" .
            $this->notification->telegram_api .
            "/setWebhook?url=" . $route . '&certificate=@sds_bot.pem';
        return $this->setCurl($url);
    }

    public function delWebHook(): bool|string
    {
        $url = 'https://api.telegram.org/bot' .
            $this->notification->telegram_api
            . '/setWebhook?url=';
        return $this->setCurl($url);
    }

    public function getWebHook(): bool|string
    {
        $url = 'https://api.telegram.org/bot' .
            $this->notification->telegram_api
            . '/getWebhookInfo';
        return $this->setCurl($url);
    }

    private function setCurl($url): bool|string
    {
        $headers = [
            "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0",
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3",
            "Cache-Control: max-age=0",
            "Connection: keep-alive",
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);

        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function checkOperation(mixed $data)
    {
        Log::info('ТЕЛЕГРАМ ПОЛУЧЕН ХУК');
        Log::info(json_encode($data));
        $message = $data['callback_query']['message'];
        $telegram_id = $message['chat']['id'];
        Log::info('ID User - '. $telegram_id);

        $callback = $message['reply_markup']['inline_keyboard'];

        Log::info('Data - '. json_encode($data['callback_query']['data']));

    }
}
