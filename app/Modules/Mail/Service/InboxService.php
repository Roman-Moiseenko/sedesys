<?php

namespace App\Modules\Mail\Service;

use App\Modules\Setting\Entity\Mail;
use App\Modules\Setting\Repository\SettingRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Mail\Entity\Inbox;
use Webklex\PHPIMAP\ClientManager;

class InboxService
{

    private Mail $mail;

    public function __construct(SettingRepository $settings)
    {
        $this->mail = $settings->getMail();
    }

   /* public function create(Request $request): Inbox
    {

          $inbox = Inbox::register(
              $request->string('name')->trim()->value(),
          );

          $this->save_fields($inbox, $request);

          return  $inbox;
    }*/


    public function destroy(Inbox $inbox)
    {
        foreach ($inbox->attachments as $file) {
            $dir = pathinfo(storage_path('app/') . $file, PATHINFO_DIRNAME);
            unlink(storage_path('app/') . $file);
        }
        if (!empty($dir)) rmdir($dir);
        $inbox->delete();
    }

    /**
     * Для версии > 1 когда будет внедрено несколько почтовых ящиков для чтения
     * @return void
     */
    public function readAllInBox()
    {
        /* foreach ($boxes as $box) {
             $this->readInbox($box['name'], $box['password']);
         } */
        $this->readInbox($this->mail->inbox_name, $this->mail->inbox_password);
    }

    public function readInbox(string $box, string $password)
    {
        $cm = new ClientManager($options = []);
        $client = $cm->make([
            'host' => 'imap.beget.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'username' => $box . '@' . $this->mail->inbox_domain,
            'password' => $password,
            'authentication' => 'OAuth2',
        ]);

        $client->connect();
        /** @var \Webklex\PHPIMAP\Folder $folder */
        $folder = $client->getFolder('INBOX');


        //$this->info($folder->name);
        //Get all Messages of the current Mailbox $folder

        /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
        $messages = $folder->query()->markAsRead()->unseen()->get();

        /** @var \Webklex\PHPIMAP\Message $message */
        foreach ($messages as $message) {
            $inbox = Inbox::register($box, $message->getFrom(), $message->getSubject());
            $inbox->message = $message->getHTMLBody();

            if ($message->getAttachments()->count() > 0) {
                /** @var \Webklex\PHPIMAP\Attachment $attachment */
                $path = 'files/inbox/' . $inbox->id . '/';
                $attach = [];
                foreach ($message->getAttachments() as $attachment) {
                    $attach[$attachment->filename] = $path . $attachment->filename;
                    $attachment->save(storage_path('app/') . $path);
                }
                $inbox->attachments = $attach;
                //TODO Скачивание файла в папку
                // storage_path('app/inbox/' . $inbox->id . '/');
            }
            $inbox->save();

            if ($this->mail->inbox_delete) $message->delete();


        }
    }
}
