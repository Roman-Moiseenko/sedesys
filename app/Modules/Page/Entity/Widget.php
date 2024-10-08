<?php

namespace App\Modules\Page\Entity;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Entity\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $template
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $data
 * @property string $options
 * @property string $model - Класс модели формата WidgetData (getImage, getUrl, getCaption, getText)
 */
class Widget extends Model
{
    use HasFactory;

    const PATH_TEMPLATES = 'web.templates.widget.';

    const WIDGET_MODELS = [
        Employee::class => 'Персонал',
        Specialization::class => 'Специализация',
        Service::class => 'Услуги',
        Classification::class => 'Классификация (услуг)',
    ];

    protected $attributes = [
        'data' => '{}',
        'options' => '{}',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'data' => 'json',
        'options' => 'json',
    ];
    protected $fillable = [
        'name',
    ];

    public static function register(string $name): self
    {
        return self::create([
            'name' => $name,
        ]);
    }

    public function view(): string
    {
        // $dataItem = $this->DataWidget();

        if (!empty($this->model)) {
            $items = $this->model::active()->getModels();
            return view(self::PATH_TEMPLATES . $this->template, ['items' => $items, 'options' => $this->options])->render();
        } else {
            return view(self::PATH_TEMPLATES . $this->template, ['data' => $this->data, 'options' => $this->options])->render();
        }

    }

    //TODO Перенести в фасад на WidgetService

    public static function findView(int $id): string
    {
        /** @var Widget $widget */
        $widget = self::find($id);
        if (is_null($widget)) return '';
        return $widget->view();
    }

    public static function renderFromText(string|null $text): string
    {
        if (is_null($text)) return '';
        preg_match_all('/\[widget=\"(.+)\"\]/', $text, $matches);
        $replaces = $matches[0]; //шот-коды вида [widget="7"] (массив)
        $widget_ids = $matches[1]; //значение id виджета (массив)

        foreach ($widget_ids as $key => $widget_id) {
            $text = str_replace(
                $replaces[$key],
                self::findView((int)$widget_id),
                $text);
        }
        return $text;
    }
}
