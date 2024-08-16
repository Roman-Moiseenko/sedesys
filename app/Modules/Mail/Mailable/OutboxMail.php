<?php
declare(strict_types=1);

namespace App\Modules\Mail\Mailable;

use App\Modules\Mail\Entity\Outbox;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use JetBrains\PhpStorm\Pure;

class OutboxMail  extends AbstractMailable
{
    public Outbox $outbox;

    public function __construct(Outbox $outbox)
    {
        parent::__construct();
        $this->outbox = $outbox;

        foreach ($outbox->attachments as $key => $attachment) {
            $this->files[$key] = storage_path('app/') . $attachment;
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->outbox->subject,
        );
    }

    #[Pure] public function content(): Content
    {
        return new Content(
            markdown: 'mail.outbox',
            with: [
                'content' => $this->outbox->message
            ],
        );
    }

    public function attachments(): array
    {
        return array_map(function ($item) {
            return Attachment::fromPath($item);
        }, $this->files);
    }

    public function getFiles(): array
    {
        return $this->files;
    }
}
