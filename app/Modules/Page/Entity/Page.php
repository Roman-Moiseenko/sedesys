<?php

namespace App\Modules\Page\Entity;

use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Web\Repository\WebRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property int $parent_id
 * @property string $template
 * @property string $text
 * @property int $sort
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
    ];

    protected $fillable = [
        'parent_id',
    ];

    public function setText(string $text)
    {
        $this->text = $text;
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
                Widget::findView((int)$widget_id),
                $text);
        }
        $this->text = $text;

        $repository = app()->make(WebRepository::class);
        $breadcrumb = $repository->getBreadcrumbModel($this);

        return view(self::PATH_TEMPLATES . $this->template,
            [
                'page' => $this,
                'meta' => $this->meta,
                'breadcrumb' => $breadcrumb,
            ]
        )->render();
    }
}
