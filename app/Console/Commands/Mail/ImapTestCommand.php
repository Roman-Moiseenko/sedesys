<?php
declare(strict_types=1);

namespace App\Console\Commands\Mail;
use App\Modules\Mail\Service\InboxService;
use App\Modules\Setting\Repository\SettingRepository;
use Illuminate\Console\Command;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Client;

class ImapTestCommand extends Command
{
    protected $signature = 'imap:test';
    protected $description = 'Тест почты';
    public function handle()
    {

        $cm = new ClientManager($options = []);
        $client = $cm->make([
            'host' => 'imap.beget.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'username' => 'info@sedesys.ru',
            'password' => '@12244DDDddd',
            'authentication' => 'OAuth2',
        ]);

        $client->connect();
        /** @var \Webklex\PHPIMAP\Folder $folder */
        $folder = $client->getFolder('INBOX');
        /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
        $messages = $folder->query()->markAsRead()->all()->get();//->new()->get();
        /** @var \Webklex\PHPIMAP\Message $message */
        foreach ($messages as $message) {

            $this->info('getFrom = ' . $message->getFrom());
            $this->info('getSender = ' . $message->getSender());
            dd($message->getFrom()->get()->mail);
            //$this->info('Письмо от ' . $message->getFrom() . ' ТЕМА ' . $message->getSubject() );
        }
    }



}
