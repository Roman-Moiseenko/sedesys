<?php

namespace App\Modules\Employee\Entity;

use App\Modules\Base\Casts\MetaCast;
use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use App\Modules\Base\Entity\SortModel;
use App\Modules\Page\Entity\WidgetData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $sort
 * @property Employee[] $employees
 */
class Specialization extends DisplayedModel implements WidgetData, SortModel
{
    use HasFactory;

    protected $fillable = [
        'sort',
    ];

    public static function register(string $name, string $slug = ''): self
    {
        $model = parent::register($name, $slug);
        $model->sort = Specialization::get()->count();
        $model->save();
        return $model;
    }

    public function isEqual(SortModel $model): bool
    {
        return $model->id == $this->id;
    }

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
        $this->save();
    }

    public function getSort(): int
    {
        return $this->sort;
    }
    //RELATIONS

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_specializations', 'specialization_id', 'employee_id')
            ->withPivot(['sort']);
    }

    //Interface
    public function getUrl(): string
    {
        return route('web.specialization.view', $this->slug);
    }

    public function getCaption(): string
    {
        return empty($this->meta->h1) ? $this->name : $this->meta->h1;
    }

    public function getText(): string
    {
        return $this->meta->description;
    }

    public function getCacheKeys(): array
    {
        return [
            'specializations',
            'specialization-' . $this->id
        ];
    }


}
