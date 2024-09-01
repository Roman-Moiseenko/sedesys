<?php

namespace App\Modules\Page\Entity;

use App\Modules\Base\Entity\SortModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property string $icon
 * @property string $url
 * @property string $color
 * @property string $title
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Contact extends Model implements SortModel
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function isActive(): bool
    {
        return $this->active == true;
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

  /*  public function getField(): mixed
    {
        return $this->field;
    }*/

    public function draft()
    {
        $this->active = false;
        $this->save();
    }

    public function activated()
    {
        $this->active = true;
        $this->save();
    }
}
