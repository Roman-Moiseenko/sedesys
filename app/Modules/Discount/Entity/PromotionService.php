<?php
declare(strict_types=1);

namespace App\Modules\Discount\Entity;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $promotion_id
 * @property int $service_id
 * @property int $price
 */
class PromotionService extends Model
{
    public $timestamps = false;
    protected $table = 'promotions_services';
}
