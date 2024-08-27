<?php

namespace App\Modules\Employee\Entity;

use App\Modules\Base\Casts\MetaCast;
use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use App\Modules\Page\Entity\WidgetData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
// * @property int $id
// * @property string $name
// * @property string $slug
// * @property bool $active
 * @property int $sort
// * @property Carbon $created_at
// * @property Carbon $updated_at
// * @property Photo $image
// * @property Photo $icon
 * @property Employee[] $employees
// * @property Meta $meta
 */
class Specialization extends DisplayedModel implements WidgetData
{
    use HasFactory;
/*
    protected $attributes = [
        'meta' => '{}',
    ];*/
/*
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'meta' => MetaCast::class,
    ];
    */

    protected $fillable = [
        /*'name',
        'slug',
        'active',*/
        'sort',
    ];

    public static function register(string $name, string $slug = ''): self
    {
        $model = parent::register($name, $slug);
        $model->sort = Specialization::get()->count();
        $model->save();
        return $model;
    }
/*
    public function isActive(): bool
    {
        return $this->active == true;
    }

    public function activated()
    {
        $this->active = true;
        $this->save();
    }

    public function draft()
    {
        $this->active = false;
        $this->save();
    }
    */
    public function setSort(int $sort): void
    {
        $this->sort = $sort;
        $this->save();
    }

    //RELATIONS
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
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_specializations', 'specialization_id', 'employee_id')
            ->withPivot(['sort']);
    }

/*
    public function getImage(string $thumb = ''):? string
    {
        if (is_null($this->image) || is_null($this->image->file)) return null;
        if (empty($thumb)) return $this->image->getUploadUrl();
        return $this->image->getThumbUrl($thumb);
    }

    public function getIcon(string $thumb = ''):? string
    {
        if (is_null($this->icon) || is_null($this->icon->file)) return null;
        if (empty($thumb)) return $this->icon->getUploadUrl();
        return $this->icon->getThumbUrl($thumb);
    }
*/
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

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
