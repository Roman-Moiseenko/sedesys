<?php

namespace App\Modules\Page\Entity;

use App\Modules\Employee\Entity\Employee;
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

    //TODO Динамический список шаблонов по файлам
    const WIDGET_TEMPLATES = [
        'gallery' => 'Галерея',
        'review' => 'Карточки',
        'employee' => 'Сотрудники',
    ];

    const WIDGET_MODELS = [
        Employee::class => 'Сотрудники',
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
            $items = $this->model::where('active', true)->getModels();
            return view(self::PATH_TEMPLATES . $this->template, ['items' => $items, 'options' => $this->options])->render();
        } else {
            return view(self::PATH_TEMPLATES . $this->template, ['data' => $this->data, 'options' => $this->options])->render();
        }

    }

    public static function findView(int $id): string
    {
        /** @var Widget $widget */
        $widget = self::find($id);
        if (is_null($widget)) return '';

        return $widget->view();
    }
}
