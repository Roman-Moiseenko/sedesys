<?php
declare(strict_types=1);

namespace App\Modules\Service\Entity;

use App\Modules\Base\Entity\Photo;
use App\Modules\Base\Entity\SortModel;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $service_id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $duration
 * @property int $sort
 * @property boolean $active
 * @property string $awesome
 * @property Photo $icon
 */
class Extra extends Model implements SortModel
{
    protected $table = 'services_extra';
    public $timestamps = false;

    protected $fillable = [
        'service_id',
        'name',
        'sort'
    ];

    public static function register(int $service_id, string $name): self
    {
        $count = Extra::where('service_id', $service_id)->count();
        return self::create([
            'service_id' => $service_id,
            'name' => $name,
            'sort' => $count,
        ]);
    }

    public static function new(string $name, int $price, int $duration, string $awesome): self
    {
        return self::make([

        ]);
    }

    public function isEqual(SortModel $model): bool
    {
        return $model->id == $this->id;
    }

    public function isActive(): bool
    {
        return $this->active == true;
    }

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

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
        $this->save();
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function icon()
    {
        return $this->morphOne(Photo::class, 'imageable')->withDefault();;
    }

    public function getIcon(string $thumb = ''): ?string
    {
        if (is_null($this->icon) || is_null($this->icon->file)) return null;
        if (empty($thumb)) return $this->icon->getUploadUrl();
        return $this->icon->getThumbUrl($thumb);
    }


}
