<?php
declare(strict_types=1);

namespace App\Console\Commands\Telegram;

use App\Modules\Notification\Service\TelegramService;
use Illuminate\Console\Command;

class DelWebHookCommand extends Command
{
    protected $signature = 'telegram:del-webhook';

    protected $description = 'Удаление вебхука';

    public function handle(TelegramService $service): bool
    {
        $result = $service->delWebHook();
        $this->info(json_encode($result));
        return true;
    }
}
