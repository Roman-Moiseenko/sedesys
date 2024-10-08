<?php
declare(strict_types=1);

namespace App\Modules\Base\Entity;

use App\Modules\Base\Casts\BreadcrumbInfoCast;
use App\Modules\Base\Casts\MetaCast;
use App\Modules\Base\Traits\IconField;
use App\Modules\Base\Traits\ImageField;
use App\Modules\Discount\Entity\Promotion;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Page\Entity\Page;
use App\Modules\Page\Entity\Widget;
use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Entity\Service;
use App\Modules\Web\Helpers\CacheHelper;
use App\Modules\Web\Helpers\Menu;
use App\Modules\Web\Repository\WebRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Родительский класс для публикуемых классов, которые имеют свою страницу и могут быть добавлены в меню и каталоги
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $awesome
 * @property bool $active
 * @property string $template //Шаблон отображения
 * @property string $text //Текст отображения
 * @property Meta $meta
 * @property BreadcrumbInfo $breadcrumb
 * @property Carbon $activated_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
abstract class DisplayedModel extends Model implements DisplayedData
{
    use ImageField, IconField;

    const LIST_MODELS = [
        Page::class => 'Страница', //create, edit, show, index
        Service::class => 'Услуга', //* * * * *
        Specialization::class => 'Специализация', //c
        Classification::class => 'Классификация', //* *
        Employee::class => 'Персонал', //c
        Promotion::class => 'Акция', //c

        //На будущее
        //Post + Widget
        //Product, Category  + Widget
        //Template::TEMPLATES => прописать путь к шаблонам, либо сделать <имя_класса> lowerCase из LIST_MODELS
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
            'text' => '',
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
/*
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
*/
    public function saveDisplayed(Request $request)
    {
        $this->name = $request->string('displayed.name')->trim()->value();
        $this->setSlug($request->string('displayed.slug')->trim()->value());

        $this->meta = new Meta(params: $request->input('displayed.meta'));
        $this->awesome = $request->string('displayed.awesome')->trim()->value();
        $this->breadcrumb = new BreadcrumbInfo(params: $request->input('displayed.breadcrumb'));
        $this->template = $request->string('displayed.template');

        $this->text = $request->string('displayed.text')->trim()->value();

        $this->save();

        /**
         * Вынесено в Trait
         */
        $this->saveImage(
            $request->file('displayed.image'),
            $request->boolean('displayed.clear_image')
        );

        $this->saveIcon(
            $request->file('displayed.icon'),
            $request->boolean('displayed.clear_icon')
        );

        //Произошло изменение страниц для меню.
        //Создать Кеш
        Cache::put(CacheHelper::MENU_TOP, Menu::menuTop());
    }

    /**
     * Гетеры
     */

    public function getActivatedAt(bool $with_time = false): string
    {
        if (is_null($this->activated_at)) return '';
        if ($with_time) return $this->activated_at->translatedFormat('j F Y H:i');

        return $this->activated_at->translatedFormat('j F Y');
    }

    public function getCreatedAt(bool $with_time = false): string
    {
        if ($with_time) return $this->created_at->translatedFormat('j F Y H:i');
        return $this->created_at->translatedFormat('j F Y');
    }
/*
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
*/
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
/*
    public function image()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type','image')->withDefault();
    }

    public function icon()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type', 'icon')->withDefault();
    }
*/
    public function view(): string
    {
        $this->text = Widget::renderFromText($this->text); //Рендерим виджеты в тексте

        $repository = app()->make(WebRepository::class);
        $breadcrumb = $repository->getBreadcrumbModel($this); //Хлебные крошки - image, текст
        $class = strtolower(class_basename(static::class)); //Класс вызвавший
        if (empty($this->template)) {
            $template = 'web.' .$class . '.show'; //Базовый шаблон системы
        } else {
            $template = 'web.templates.' . $class . '.' . $this->template; //Выбранный шаблон
        }

        //dd($this);
        return view($template,
            [
                $class => $this,
                'meta' => $this->meta,
                'breadcrumb' => $breadcrumb,
            ]
        )->render();
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

    //Для создания таблиц
    final public static function columns(Blueprint $table)
    {
        $table->string('name');
        $table->string('slug');
        $table->string('awesome')->nullable();
        $table->boolean('active')->default(false);
        $table->json('meta');
        $table->json('breadcrumb');
        $table->timestamp('activated_at')->nullable();
        $table->timestamps();
        $table->string('template')->nullable();
        $table->longText('text')->nullable();
        $table->index('slug');
    }

    final public static function dropColumns(Blueprint $table)
    {
        $table->dropIndex('slug');

        $table->dropColumn('name');
        $table->dropColumn('slug');
        $table->dropColumn('created_at');
        $table->dropColumn('updated_at');
        $table->dropColumn('activated_at');
        $table->dropColumn('active');
        $table->dropColumn('awesome');
        $table->dropColumn('meta');
        $table->dropColumn('breadcrumb');
        $table->dropColumn('template');
        $table->dropColumn('text');

    }
}
