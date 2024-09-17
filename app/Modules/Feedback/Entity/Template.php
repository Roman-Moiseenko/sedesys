<?php

namespace App\Modules\Feedback\Entity;

use App\Modules\Base\Entity\Photo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string $template
 * @property boolean $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Feedback[] $feedbacks
 */
class Template extends Model
{
    use HasFactory;

    protected $attributes = [
        'template' => '',
    ];
    protected $table='feedback_templates';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'name',
        'active'
    ];

    public static function register(string $name): self
    {
        return self::create([
            'name' => $name,
            'active' => false
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

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'template_id', 'id')->orderByDesc('created_at');
    }

    /**
     * Хелперы и Интерфейсы
     */
}
