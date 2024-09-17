<?php

namespace App\Modules\Feedback\Entity;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Base\Entity\Photo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\select;

/**
 * @property int $id
 * @property int $template_id
 * @property int $staff_id
 * @property string $email
 * @property string $phone
 * @property string $user
 * @property string $message
 * @property array $data
 * @property int $status
 * @property bool $archive
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $completed_at
 * @property Template $template
 * @property Admin $staff
 */
class Feedback extends Model
{
    use HasFactory;

    const STATUS_NEW = 101;
    const STATUS_WORK = 102;
    const STATUS_COMPLETED = 103;

    const STATUSES = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_WORK => 'В работе',
        self::STATUS_COMPLETED => 'Завершено',
    ];
    protected $attributes = [
        'data' => '{}',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'data' => 'json',
    ];
    protected $fillable = [
        'template_id',
        'status',
    ];

    public static function register(int $template_id): self
    {
        return self::create([
            'template_id' => $template_id,
            'status' => self::STATUS_NEW
        ]);
    }

    /**
     * Ф-ции состояния
     */
    public function isArchive(): bool
    {
        return $this->archive == true;
    }

    public function isCompleted(): bool
    {
        return $this->status == self::STATUS_COMPLETED;
    }
    /**
     * Сетеры
     */

    public function completed()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = now();
        $this->save();
    }

    public function archive()
    {
        $this->archive = true;
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = now();
        $this->save();
    }

    public function cancelArchive()
    {
        $this->archive = false;
        $this->status = self::STATUS_NEW;
        $this->save();
    }

    /**
     * Гетеры
     */

    /**
     * Отношения
     */
    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Admin::class, 'staff_id', 'id')->withDefault();
    }

    public function statusHtml(): string
    {
        return self::STATUSES[$this->status];
    }

    public function setStaff(int $id)
    {
        $this->staff_id = $id;
        $this->status = self::STATUS_WORK;
        $this->save();
    }


    /**
     * Хелперы и Интерфейсы
     */
}
