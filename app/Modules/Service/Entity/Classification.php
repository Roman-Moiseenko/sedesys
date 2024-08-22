<?php

namespace App\Modules\Service\Entity;

use App\Modules\Base\Casts\MetaCast;
use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use App\Modules\Page\Entity\WidgetData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Classification $parent
 * @property Classification[] $children
 * @property Photo $image
 * @property Photo $icon
 * @property Meta $meta
 */
class Classification extends Model implements WidgetData
{
    use HasFactory, NodeTrait;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'meta' => MetaCast::class,
    ];
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public static function register(string $name, int $parent_id = null, string $slug = ''): self
    {
        return self::create([
            'name' => $name,
            'parent_id' => $parent_id,
            'slug' => empty($slug) ? Str::slug($name) : $slug,
        ]);
    }

    public function isField(): bool
    {
        /**
         * Ф-ции состояния
         */
        return true;
    }

    public function setField($value): void
    {
        /**
         * Сетеры
         */
        $this->field = $value;
        $this->save();
    }

    public function getField(): mixed
    {
        /**
         * Гетеры
         */
        return $this->field;
    }


    public function services()
    {
        //TODO После создания Service

        return 0;
    }

    public function image()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type', '=','image')->withDefault();
    }

    public function icon()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type', '=', 'icon')->withDefault();
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
        return route('web.classification.view', $this->slug);
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
        return $query;
    }
}
