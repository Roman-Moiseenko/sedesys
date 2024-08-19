<?php
declare(strict_types=1);

namespace App\Modules\User\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property string $network
 * @property string $identity
 *
 * @property User $user
 */
class OAuth extends Model
{
    const YANDEX = 'yandex';
    const VK = 'vk';
    const GOOGLE = 'google';
    const TELEGRAM = 'telegram';

    const NETWORKS = [
        self::YANDEX => 'Яндекс',
        self::VK => 'ВКонтакте',
        self::GOOGLE => 'Гугл',
        self::TELEGRAM => 'Телеграм',
    ];

    protected $table = 'oauths';
    protected $fillable = [
        'user_id',
        'network',
        'identity',
    ];

    public static function new(string $network, string $identity): self
    {
        return self::make([
            //'user_id' => $user_id,
            'network' => $network,
            'identity' => $identity,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
