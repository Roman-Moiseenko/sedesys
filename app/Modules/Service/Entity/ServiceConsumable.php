<?php
declare(strict_types=1);

namespace App\Modules\Service\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $service_id
 * @property int $consumable_id
 * @property int $count
 */
class ServiceConsumable extends Model
{
    public $timestamps = false;
    protected $table = 'services_consumables';

}
