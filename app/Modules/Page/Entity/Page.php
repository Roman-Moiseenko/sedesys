<?php

namespace App\Modules\Page\Entity;

use App\Modules\Base\Entity\Photo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $template
 * @property string $text
 * @property bool $published
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $published_at
 * @property Photo $photo
 */

class Page extends Model
{
    use HasFactory;
    const PATH_TEMPLATES = 'web.templates.page.';

    protected $attributes = [
        'description' => '',
        'text' => '',
    ];

    const PAGES_TEMPLATES = [
        'contact' => 'Контакты',
        'review' => 'Отзывы',
        'tariff' => 'Тарифы',
        'text' => 'Текстовая',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'published_at' => 'datetime',
    ];
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'title',
        'description',
        'template',
        'sort',
    ];

    public static function register(string $name, string $slug = ''): self
    {
        //$sort = Page::where('parent_id', $parent_id)->max('sort');
        return self::create([
            'name' => $name,
            'slug' => empty($slug) ? Str::slug($name) : $slug,
            'published' => false,
            'text' => '',
        ]);
    }

    public function isPublished(): bool
    {
        return $this->published == true;
    }

    public function setText(string $text)
    {
        $this->text = $text;
        $this->save();
    }

    public function draft()
    {
        $this->published = false;
        $this->save();
    }

    public function published()
    {
        if (is_null($this->published_at)) $this->published_at = now();
        $this->published = true;
        $this->save();
    }

    public function view(): string
    {
        $text = $this->text;
        preg_match_all('/\[widget=\"(.+)\"\]/', $text, $matches);
        $replaces = $matches[0]; //шот-коды вида [widget="7"] (массив)
        $widget_ids = $matches[1]; //значение id виджета (массив)

        foreach ($widget_ids as $key => $widget_id) {
            $text = str_replace(
                $replaces[$key],
                Widget::findView($widget_id),
                $text);
        }
        $this->text = $text;

        return view(self::PATH_TEMPLATES . $this->template,
            [
                'page' => $this,
                'title' => $this->title,
                'description' => $this->description,
            ]
        )->render();
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'imageable');//->withDefault();
    }

}
