<?php

namespace App\Modules\Page\Entity;

use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Web\Repository\WebRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property int $parent_id
 * @property int $sort
 */

class Page extends DisplayedModel
{
    use HasFactory, NodeTrait;

    protected $attributes = [
        'parent_id' => null,
    ];

    protected $fillable = [
        'parent_id',
    ];

    public function getCacheKeys(): array
    {
        return [
            'pages',
            'page-' . $this->id
        ];
    }
}
