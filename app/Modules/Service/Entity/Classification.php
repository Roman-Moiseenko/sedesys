<?php

namespace App\Modules\Service\Entity;

use App\Modules\Base\Casts\MetaCast;
use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use App\Modules\Page\Entity\WidgetData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

/**
// * @property int $id
 * @property int $parent_id
// * @property string $name
// * @property string $slug
// * @property Carbon $created_at
// * @property Carbon $updated_at
 *
 * @property Classification $parent
 * @property Classification[] $children
// * @property Photo $image
// * @property Photo $icon
// * @property Meta $meta
 * @property Service[] $services
 */
class Classification extends DisplayedModel implements WidgetData
{
    use HasFactory, NodeTrait;

    protected $attributes = [
        'parent_id' => null
    ];

  /*  protected $fillable = [
        'parent_id',
    ];*/

    public function services()
    {
       return $this->hasMany(Service::class, 'classification_id', 'id');
    }

    public function getUrl(): string
    {
        return route('web.classification.view', $this->slug);
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
            'classifications',
            'classification-' . $this->id
        ];
    }
}
