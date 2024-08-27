<?php

namespace App\Modules\Page\Entity;

use App\Modules\Base\Casts\MetaCast;
use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use App\Modules\Base\Traits\DisplayedClass;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

/**
 //* @property int $id
 * @property int $parent_id
 //* @property string $name
 //* @property string $slug
 * @property string $template
 * @property string $text
 * @property int $sort
 //* @property Carbon $created_at
 //* @property Carbon $updated_at
 //* @property Photo $image
// * @property Photo $icon
// * @property Meta $meta
 */

class Page extends DisplayedModel
{
    use HasFactory, NodeTrait;

    const PATH_TEMPLATES = 'web.templates.page.';
    const PAGES_TEMPLATES = [
        'contact' => 'Контакты',
        'review' => 'Отзывы',
        'tariff' => 'Тарифы',
        'text' => 'Текстовая',
    ];

    protected $attributes = [
        'text' => '',
        'parent_id' => null,
       // 'meta' => '{}',
    ];
   // protected $casts = [
     //   'created_at' => 'datetime',
    //    'updated_at' => 'datetime',
    //    'published_at' => 'datetime',
     //   'meta' => MetaCast::class,
   // ];

    protected $fillable = [
        'parent_id',
     //   'name',
   //     'slug',
    //    'title',
   //     'template',
   //     'sort',
    ];

   /* public static function register(string $name, string $slug = ''): self
    {
        return self::create([
            'name' => $name,
            'slug' => empty($slug) ? Str::slug($name) : $slug,
            'published' => false,
        ]);
    }*/

   /* public function isPublished(): bool
    {
        return $this->published == true;
    }*/

    public function setText(string $text)
    {
        $this->text = $text;
        $this->save();
    }
/*
    public function draft()
    {
        $this->published = false;
        $this->save();
    }*/

  /*  public function published()
    {
        if (is_null($this->published_at)) $this->published_at = now();
        $this->published = true;
        $this->save();
    }*/

    public function view(): string
    {
        $text = $this->text;
        preg_match_all('/\[widget=\"(.+)\"\]/', $text, $matches);
        $replaces = $matches[0]; //шот-коды вида [widget="7"] (массив)
        $widget_ids = $matches[1]; //значение id виджета (массив)

        foreach ($widget_ids as $key => $widget_id) {
            $text = str_replace(
                $replaces[$key],
                Widget::findView((int)$widget_id),
                $text);
        }
        $this->text = $text;

        return view(self::PATH_TEMPLATES . $this->template,
            [
                'page' => $this,
                'meta' => $this->meta,
            ]
        )->render();
    }

/*
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
        return route('web.page.view', $this->slug);
    }

    public function getCaption(): string
    {
        return empty($this->meta->h1) ? $this->name : $this->meta->h1;
    }

    public function getText(): string
    {
        return $this->meta->description;
    }
*/
   /* public function scopeActive($query)
    {
        return $query->where('published', true);
    }*/
}
