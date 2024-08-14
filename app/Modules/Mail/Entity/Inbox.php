<?php

namespace App\Modules\Mail\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property array $attachments
 * @property bool $read
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Inbox extends Model
{
    use HasFactory;

    protected $attributes = [
        'attachments' => '{}',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'attachments' =>'json',
    ];
    protected $fillable = [
        'email',
        'subject',
        'message',
        'attachments',
        'read',
    ];

    public static function register(string $email, string $subject, string $message, array $attachments): self
    {
        return self::create([
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'attachments' => $attachments,
            'read' => false
        ]);
    }

    public function isRead(): bool
    {
        return $this->read == true;
    }

    public function read(): void
    {
        $this->read = true;
        $this->save();
    }

}
