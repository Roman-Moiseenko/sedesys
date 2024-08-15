<?php
declare(strict_types=1);

namespace App\Modules\Mail\Mailable;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\Pure;

class TestMail extends AbstractMailable
{
    use Queueable, SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
           // from: 'Служба оповещения SeDeSys',
            subject: 'Служебное письмо',
        );
    }

    #[Pure]
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.test',
            with: [
            ],
        );
    }

    public function attachments(): array
    {
        $path = storage_path('app/files/order/0/');
        return [
            Attachment::fromPath($path . 'test-01.txt'),
            Attachment::fromPath($path . 'test-02.txt'),
        ];
    }
}
