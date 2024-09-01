<?php

namespace App\Modules\Service\Entity;

use App\Modules\Base\Entity\Photo;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Casts\ExternalReviewCast;
use App\Modules\User\Entity\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $service_id
 * @property int $employee_id
 * @property bool $active
 * @property int $rating
 * @property string $text
 * @property ExternalReview $external ///Для отзывов внесенных сотрудниками или полученными по API
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property Service $service
 * @property Employee $employee
 * @property Photo[] $gallery
 */
class Review extends Model
{
    use HasFactory;

    protected $table = 'service_reviews';
    protected $attributes = [
        'text' => '',
        'external' => '{}'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'external' => ExternalReviewCast::class,
    ];

    protected $fillable = [
        'service_id',
    ];

    public static function register(int $service_id): self
    {
        return self::create([
            'service_id' => $service_id,
        ]);
    }

    /**
     * Ф-ции состояния
     */
    public function isActive(): bool
    {
        return $this->active == true;
    }

    /**
     * Сетеры
     */
    public function activated(): void
    {
        $this->active = true;
        $this->save();
    }

    public function draft(): void
    {
        $this->active = false;
        $this->save();
    }

    /**
     * Гетеры
     */


    /**
     * Отношения
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function gallery()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function getFrom(): string
    {
        if (is_null($this->user_id))
            return $this->external->user_name . ' (' . $this->external->getNameService() . ')';
        return $this->user->fullname->getShortname();
    }

    public function getDate(): string
    {
        return $this->created_at->translatedFormat('j F Y');
    }
    /**
     * Хелперы и Интерфейсы
     */
}
