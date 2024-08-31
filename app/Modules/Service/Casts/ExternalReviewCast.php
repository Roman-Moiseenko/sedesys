<?php
declare(strict_types=1);

namespace App\Modules\Service\Casts;

use App\Modules\Base\Entity\FullName;
use App\Modules\Service\Entity\ExternalReview;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ExternalReviewCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return ExternalReview::fromArray(json_decode($value, true));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return json_encode($value->toArray());
    }
}
