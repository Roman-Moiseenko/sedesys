<?php

namespace App\Modules\Service\Entity;

use App\Modules\Base\Casts\MetaCast;
use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use App\Modules\Base\Traits\GalleryField;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Page\Entity\Widget;
use App\Modules\Page\Entity\WidgetData;
use App\Modules\Web\Repository\WebRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $classification_id
 * @property int $price // В рублях
 * @property int $duration // В минутах
 * @property string $data // json данных, можно использовать в шаблоне
 *
 * @property Classification $classification
 * @property Employee[] $employees
 * @property Example[] $examples
 * @property Review[] $reviews
 * @property Extra[] $extras
 * @property Consumable[] $consumables
 */
class Service extends DisplayedModel implements WidgetData
{
    use HasFactory, GalleryField;

    protected $attributes = [
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

    public function extras()
    {
        return $this->hasMany(Extra::class, 'service_id', 'id')->orderBy('sort');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'service_id', 'id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_services', 'service_id', 'employee_id')->withPivot(['extra_cost']);
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id', 'id');
    }
/*
    public function gallery()
    {
        return $this->morphMany(Photo::class, 'imageable')->where('type','gallery');
    }
*/
    public function consumables()
    {
        return $this->belongsToMany(Consumable::class, 'services_consumables', 'service_id', 'consumable_id')
            ->withPivot('count');
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

    public function getCacheKeys(): array
    {
        return [
            'services',
            'service-' . $this->id,
            'classification-' . $this->classification_id
        ];
    }
/*
    public function view(): string
    {

        $this->text = Widget::renderFromText($this->text);

        $repository = app()->make(WebRepository::class);
        $breadcrumb = $repository->getBreadcrumbModel($this);
        $meta = $this->meta;

        return view(self::PATH_TEMPLATES . $this->template,
            [
                'service' => $this,
                'meta' => $meta,
                'breadcrumb' => $breadcrumb,
            ]
        )->render();

    }*/
}
