<?php

namespace App\Modules\Calendar\Entity;

use App\Modules\Base\Entity\Photo;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Entity\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $regularity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $max
 * @property bool $active
 * @property Service[] $services
 * @property Employee[] $employees
 */
class Rule extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'name',
        'regularity',
        'active',
    ];

    public static function register(string $name, int $regularity): self
    {
        return self::create([
            'name' => $name,
            'regularity' => $regularity,
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
    public function draft()
    {
        $this->active = false;
        $this->save();
    }

    public function activated()
    {
        $this->active = true;
        $this->save();
    }

    /**
     * Гетеры
     */
    public function getField(): mixed
    {

        return $this->field;
    }

    /**
     * Отношения
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'rules_services','rule_id','service_id', );
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'rules_employees', 'rule_id','employee_id');
    }

    /**
     * Хелперы и Интерфейсы
     */

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
