<?php
declare(strict_types=1);

namespace App\Modules\Employee\Entity;

use App\Modules\Service\Entity\Service;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $employee_id
 * @property int $service_id
 * @property int $extra_cost
 * @property Employee $employee
 * @property Service $service
 */
class EmployeeService extends Model
{
    protected $table = 'employees_services';
    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
