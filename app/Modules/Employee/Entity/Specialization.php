<?php

namespace App\Modules\Employee\Entity;

use App\Modules\Base\Entity\Photo;
use App\Modules\Page\Entity\WidgetData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $caption //Заголовок h1
 * @property string $title //Заголовок мета
 * @property string $description
 * @property bool $active
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Photo $image
 * @property Photo $icon
 * @property Employee[] $employees
 */
class Specialization extends Model implements WidgetData
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'name',
        'slug',
        'active',
        'sort',
    ];

    public static function register(string $name, string $slug = ''): self
    {
        return self::create([
            'name' => $name,
            'slug' => empty($slug) ? Str::slug($name) : $slug,
            'active' => false,
            'sort' => Specialization::get()->count(),
        ]);
    }

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
    public function setSort(int $sort): void
    {
        $this->sort = $sort;
        $this->save();
    }

    //RELATIONS
    public function image()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type','image')->withDefault();
    }

    public function icon()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('type', 'icon')->withDefault();
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_specializations', 'specialization_id', 'employee_id')
            ->withPivot(['sort']);
    }

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

    public function getUrl(): string
    {
        return route('web.specialization.view');
    }

    public function getCaption(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->description;
    }
}
