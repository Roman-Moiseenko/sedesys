<?php
declare(strict_types=1);

namespace App\Modules\Calendar\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $rule_id
 * @property int $service_id
 */
class RuleService extends Model
{
    public $timestamps = false;
    protected $table = 'rules_services';
}
