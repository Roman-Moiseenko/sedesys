<?php
declare(strict_types=1);

namespace App\Modules\Base\Entity;

use App\Modules\Base\Casts\BreadcrumbInfoCast;
use App\Modules\Base\Casts\MetaCast;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Page\Entity\Page;
use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Entity\Service;
use App\Modules\Web\Helpers\CacheHelper;
use App\Modules\Web\Helpers\Menu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Родительский класс для публикуемых классов, которые имеют свою страницу и могут быть добавлены в меню и каталоги
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $awesome
 * @property Meta $meta
 * @property bool $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $activated_at
 * @property Photo $image
 * @property Photo $icon
 * @property BreadcrumbInfo $breadcrumb
 *
 */
abstract class DisplayedModel extends Model implements DisplayedData
{
    const LIST_MODELS = [
        Specialization::class => 'Специализация',
        Service::class => 'Услуги',
        Classification::class => 'Классификация',
        Page::class => 'Страница',
        Employee::class => 'Персонал',

        //На будущее
        //Post + Widget
        //Product, Category  + Widget
    ];

    /**
     * Объединяем базовые параметры
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $casts = [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'activated_at' => 'datetime',
            'meta' => MetaCast::class,
            'breadcrumb' => BreadcrumbInfoCast::class,
        ];
        $fillable = [
            'name',
            'slug',
            'active',
        ];
        $attributes = [
            'meta' => '{}',
            'breadcrumb' => '{}',
        ];

        $this->casts = array_merge($this->casts, $casts);
        $this->fillable = array_merge($this->fillable, $fillable);
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    public static function register(string $name, string $slug = ''): self
    {
        $model = static::make([
            'name' => $name,
            'active' => false,
        ]);
        $model->setSlug($slug);
        $model->save();
        return $model;
    }

    abstract public function getCacheKeys(): array;

    /**
     * Функции состояния
     */

    public function isActive(): bool
    {
        return $this->active == true;
    }

    /**
     * Сетеры
     */

    public function setSlug(string $slug = ''): void
    {
        $this->slug = empty($slug) ? Str::slug($this->name) : $slug;
    }

    public function draft()
    {
        $this->active = false;
        $this->save();
    }

    public function activated()
    {
        if (is_null($this->activated_at)) $this->activated_at = now();
        $this->active = true;
        $this->save();
    }

    protected function saveImage($file, bool $clear_current = false): void
    {
        if ($clear_current && (!is_null($this->image) || !is_null($this->image->file)))
            $this->image->delete();

        if (empty($file)) return;
        $this->image->newUploadFile($file, 'image');
    }

    protected function saveIcon($file, bool $clear_current = false): void
    {
        if ($clear_current && (!is_null($this->icon) || !is_null($this->icon->file)))
            $this->icon->delete();

        if (empty($file)) return;
        $this->icon->newUploadFile($file, 'icon');
    }

    public function saveDisplayed(Request $request)
    {
        //$this->meta = Meta::fromRequest($request);
        $this->meta = new Meta(params: $request->input('meta', []));
        $this->awesome = $request->string('awesome')->trim()->value();
        $this->breadcrumb = new BreadcrumbInfo(params: $request->input('breadcrumb', []));
        $this->save();

        $this->saveImage(
            $request->file('image'),
            $request->boolean('clear_image')
        );

        $this->saveIcon(
            $request->file('icon'),
            $request->boolean('clear_icon')
        );

        //$this->breadcrumb = BreadcrumbInfo::fromRequest($request->input('breadcrumb', []));


        //Произошло изменение страниц для меню.
        //Создать Кеш
        Cache::put(CacheHelper::MENU_TOP, Menu::menuTop());
    }

    /**
     * Гетеры
     */

    public function getActivatedAt(): string
    {
        return is_null($this->activated_at) ? '' : $this->activated_at->translatedFormat('d F Y');
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

    public function getAwesome(): string
    {
        if (empty($this->awesome)) return '';

        return '<i class="' . $this->awesome . '"></i>';
    }

    public function getName()
    {
        return $this->name;
    }
    /**
     * Отношения
     */

    public function image()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type','image')->withDefault();
    }

    public function icon()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type', 'icon')->withDefault();
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public static function boot()
    {
        parent::boot();
        self::saving(function (DisplayedModel $object) {
            foreach ($object->getCacheKeys() as $cacheKey) {
                Cache::forget($cacheKey);
            }
            //TODO Сброс Cache
            // ?? сохранить новое значение
        });


    }

}
