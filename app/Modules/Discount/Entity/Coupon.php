<?php

namespace App\Modules\Discount\Entity;

use App\Modules\Base\Entity\Photo;
use App\Modules\User\Entity\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $bonus - сумма скидки
 * @property int $status
 * @property string $code
 * @property int $min - мин.сумма заказа, =0

 * @property Carbon $finished_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 */
class Coupon extends Model
{
    use HasFactory;

    const NEW = 501;
    const STARTED = 502; //Можно использовать, ??? Cron задача ?
    const EXPIRED = 503; //Дата завершения прошла, купонном не воспользовались expired
    const USED = 505; //Использован

    const STATUSES = [
        self::NEW => 'Новый',
        self::EXPIRED => 'Просрочен',
        self::USED => 'Использован',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
    protected $fillable = [
        'user_id',
        'bonus',
        'finished_at',
        'min',
        'status',
    ];

    public static function register(int $user_id, int $bonus, string $code, $finished_at, int $min): self
    {
        return self::create([
            'user_id' => $user_id,
            'code' => $code,
            'bonus' => $bonus,
            'finished_at' => $finished_at,
            'min' => $min,
            'status' => self::NEW,
        ]);
    }

    /**
     * Ф-ции состояния
     */
    public function isNew(): bool
    {
        return $this->status = self::NEW;
    }

    public function isExpired(): bool
    {
        return $this->status = self::EXPIRED;
    }

    public function isUsed(): bool
    {
        return $this->status = self::USED;
    }
    /**
     * Сетеры
     */
    public function expired(): void
    {
        $this->status = self::EXPIRED;
        $this->save();
    }

    /**
     * Гетеры
     */



    public function statusText(): string
    {
        return self::STATUSES[$this->status];
    }

    /**
     * Отношения
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Хелперы и Интерфейсы
     */
}
