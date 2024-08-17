<?php
declare(strict_types=1);

namespace App\Console\Commands\Mail;
use App\Modules\Mail\Service\InboxService;
use App\Modules\Setting\Repository\SettingRepository;
use Illuminate\Console\Command;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Client;

class InboxCommand extends Command
{
    protected $signature = 'inbox:load';
    protected $description = 'Получение почты';
    public function handle(InboxService $service)
    {
        try {
            $service->readAllInBox();
        } catch (\Throwable $e) {
           $this->info($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            //TODO Добавить Информирование
        }
    }
}
