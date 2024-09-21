<?php

namespace App\Modules\Service\Entity;

use App\Modules\Base\Entity\Photo;
use App\Modules\Base\Traits\ImageField;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property bool $active // участвует или нет в формировании цены, доступно для выбора
 * @property bool $show //Показывать в карточке услуги
 * @property int $count //В наличии
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Photo $image
 * @property Service[] $services
 */
class Consumable extends Model
{
    use HasFactory, ImageField;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'name',
        'active',
    ];

    public static function register(string $name): self
    {
        return self::create([
            'name' => $name,
            'active' => false,
        ]);
    }

    /**
     * Ф-ции состояния
     */
    public function isActive(): bool
    {
        return $this->active == true;
    }
    public function  isShow(): bool
    {
        return $this->show == true;
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

    public function services()
    {
        return $this->belongsToMany(Service::class, 'services_consumables', 'consumable_id', 'service_id')
            ->withPivot('count');
    }


    /**
     * Хелперы и Интерфейсы
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
