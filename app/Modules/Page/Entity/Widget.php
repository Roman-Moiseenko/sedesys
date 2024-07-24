<?php

namespace App\Modules\Page\Entity;

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
 */
class Widget extends Model
{
    use HasFactory;
    const PATH_TEMPLATES = 'web.templates.widget.';

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
        return view(self::PATH_TEMPLATES . $this->template, ['data' => $this->data, 'options' => $this->options])->render();
    }

    public static function findView(int $id): string
    {
        /** @var Widget $widget */
        $widget = self::find($id);
        if (is_null($widget)) return '';

        return $widget->view();
    }
}
