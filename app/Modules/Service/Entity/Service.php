<?php

namespace App\Modules\Service\Entity;

use App\Modules\Base\Casts\MetaCast;
use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Page\Entity\WidgetData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $classification_id
 * @property string $text
 * @property int $price // В рублях
 * @property int $duration // В минутах
 * @property string $template //Шаблон, либо общий, либо для каждой услуги свой
 * @property string $data // json данных, можно использовать в шаблоне
 *
 * @property Classification $classification
 * @property Photo[] $gallery //Галерея изображений
 * @property Employee[] $employees
 * @property Example[] $examples
 */
class Service extends DisplayedModel implements WidgetData
{
    use HasFactory;

    protected $attributes = [
        'text' => '',
        'data' => '{}',
    ];
    protected $casts = [
        'data' => 'json',
    ];

    public function setPrice($price): void
    {
        $this->price = $price;
        $this->save();
    }

    /**
     * Гетеры
     */

    public function getDurationText(): string
    {
        $hour = intdiv($this->duration, 60);
        $minute = $this->duration % 60;
        $result = '';
        if ($hour > 8) {
            $result = intdiv($hour, 8) . " дн.";
            $hour = $hour % 8;
        }
        if ($hour > 0) $result .= $hour ."ч ";
        if ($minute > 0) $result .= $minute ."мин";
        return $result;
    }

    public function getClassificationName(): string
    {
        return is_null($this->classification_id) ? '' : $this->classification->name;
    }

    /**
     * Отношения
     */

    public function examples()
    {
        return $this->hasMany(Example::class, 'service_id', 'id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_services', 'service_id', 'employee_id')->withPivot(['extra_cost']);
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id', 'id');
    }

    public function gallery()
    {
        return $this->morphMany(Photo::class, 'imageable')->where('type','gallery');
    }

    //Interface
    public function getUrl(): string
    {
        return route('web.service.view', $this->slug);
    }

    public function getCaption(): string
    {
        return empty($this->meta->h1) ? $this->name : $this->meta->h1;
    }

    public function getText(): string
    {
        return $this->meta->description;
    }

}
