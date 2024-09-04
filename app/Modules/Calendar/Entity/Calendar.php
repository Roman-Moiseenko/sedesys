<?php

namespace App\Modules\Calendar\Entity;

use App\Modules\Base\Entity\Photo;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Entity\Service;
use App\Modules\User\Entity\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $service_id
 * @property int $employee_id
 * @property int $user_id
 * @property int $status
 * @property Carbon $record_at
 * @property string $comment
 * @property Service $service
 * @property Employee $employee
 * @property User $user
 */
class Calendar extends Model
{
    use HasFactory;
    const RECORD_NEW = 1010;
    const RECORD_CONFIRM = 1011;
    const RECORD_COMPLETED = 1012;
    const RECORD_CANCEL = 1013;

    public $timestamps = false;
    protected $casts = [
        'record_at' => 'datetime',
    ];
    protected $fillable = [
        'service_id',
        'user_id',
        'record_at',
        'status',
    ];

    public static function register(int $service_id, int $user_id, $record_at): self
    {
        return self::create([
            'service_id' => $service_id,
            'user_id' => $user_id,
            'record_at' => $record_at,
            'status' => self::RECORD_NEW
        ]);
    }

    /**
     * Ф-ции состояния
     */
    public function isNew(): bool
    {
        return $this->status == self::RECORD_NEW;
    }

    public function isConfirm(): bool
    {
        return $this->status == self::RECORD_CONFIRM;
    }

    public function isCompleted(): bool
    {
        return $this->status == self::RECORD_COMPLETED;
    }

    public function isCancel(): bool
    {
        return $this->status == self::RECORD_CANCEL;
    }



    /**
     * Сетеры
     */
    public function setEmployee(int $employee_id): void
    {
        $this->employee_id = $employee_id;
        $this->save();
    }

    public function confirm()
    {
        $this->status = self::RECORD_CONFIRM;
        $this->save();
    }

    public function cancel()
    {
        $this->status = self::RECORD_CANCEL;
        $this->save();
    }

    public function completed()
    {
        $this->status = self::RECORD_COMPLETED;
        $this->save();
    }

    /**
     * Гетеры
     */

    public function getDate(): string
    {
        return $this->record_at->format('d-m-Y');
    }


    public function getTime(): string
    {
        return $this->record_at->format('H:i');
    }

    /**
     * Отношения
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



    /**
     * Хелперы и Интерфейсы
     */
}
