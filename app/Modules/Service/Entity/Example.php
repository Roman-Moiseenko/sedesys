<?php

namespace App\Modules\Service\Entity;

use App\Modules\Base\Entity\Photo;
use App\Modules\Base\Traits\GalleryField;
use App\Modules\Employee\Entity\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $service_id
 * @property int $cost
 * @property string $duration - Текстом, т.к. носит информационный характер
 * @property string $title
 * @property string $description
 * @property boolean $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $date
 * @property Service $service
 * @property Employee[] $employees
 */
class Example extends Model
{
    use HasFactory, GalleryField;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date' => 'datetime',
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
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_examples', 'example_id', 'employee_id');
    }
/*
    public function gallery()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function getImage(int $sort, string $thumb = 'card'): string
    {

        $images = $this->gallery()->getModels();
        $count = count($images);
        if ($count == 0) return '';
        $pos = $sort - 1;
        if ( ($count - 1) < $pos ) $pos = $count - 1;
        return $images[$pos]->getThumbUrl($thumb);
    }
*/
    /**
     * Хелперы и Интерфейсы
     */
}
