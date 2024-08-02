<?php

namespace App\Modules\Page\Entity;

use App\Modules\Base\Entity\Photo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Photo[] $photos
 */
class Gallery extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'name',
        'slug',
    ];

    public static function register(string $name, string $slug = ''): self
    {
        return self::create([
            'name' => $name,
            'slug' => empty($slug) ? Str::slug($name) : $slug,
        ]);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public static function photo(int $id, string $thumb = 'original')
    {
        /** @var Photo $photo */
        $photo = Photo::find($id);
        return $photo->getThumbUrl($thumb);
    }

}
