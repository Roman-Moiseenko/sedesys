<?php

namespace App\Modules\Service\Entity;

use App\Modules\Base\Casts\MetaCast;
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
 * @property int $id
 * @property int $classification_id
 * @property string $name
 * @property string $slug
 * @property string $text
 * @property bool $active
 * @property int $price // В рублях
 * @property int $duration // В минутах
 * @property string $template //Шаблон, либо общий, либо для каждой услуги свой
 * @property string $data // json данных, можно использовать в шаблоне
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Classification $classification
 * @property Photo $image //Главное фото на карточку
 * @property Photo $icon //Иконка в меню, в список и т.п.
 * @property Meta $meta
 * @property Photo[] $gallery //Галерея изображений
 * @property Employee[] $employees
 *
 */
class Service extends Model implements WidgetData
{
    use HasFactory;

    protected $attributes = [
        'text' => '',
        'meta' => '{}',
        'data' => '{}',

    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'meta' => MetaCast::class,
        'data' => 'json',
    ];
    protected $fillable = [
        'name',
        'slug',
        'classification_id',
        'active',
    ];

    public static function register(string $name, int $classification_id = null, string $slug = ''): self
    {
        return self::create([
            'name' => $name,
            'classification_id' => $classification_id,
            'slug' => empty($slug) ? Str::slug($name) : $slug,
            'active' => false,
        ]);
    }

    public function isActive(): bool
    {
        return $this->active == true;
    }

    public function activated()
    {
        $this->active = true;
        $this->save();
    }

    public function draft()
    {
        $this->active = false;
        $this->save();
    }

    public function setPrice($price): void
    {
        /**
         * Сетеры
         */
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
        return "$hour\ч $minute\мин";
    }

    public function getClassificationName(): string
    {
        return is_null($this->classification_id) ? '' : $this->classification->name;
    }

    /**
     * Отношения
     */

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id', 'id');
    }

    public function gallery()
    {
        return $this->morphMany(Photo::class, 'imageable')->where('type','gallery');
    }

    public function image()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type','image')->withDefault();
    }

    public function icon()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type', 'icon')->withDefault();
    }

    public function getImage(string $thumb = ''): ?string
    {
        if (is_null($this->image) || is_null($this->image->file)) return null;
        if (empty($thumb)) return $this->image->getUploadUrl();
        return $this->image->getThumbUrl($thumb);
    }

    public function getIcon(string $thumb = ''): ?string
    {
        if (is_null($this->icon) || is_null($this->icon->file)) return null;
        if (empty($thumb)) return $this->icon->getUploadUrl();
        return $this->icon->getThumbUrl($thumb);
    }

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

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
