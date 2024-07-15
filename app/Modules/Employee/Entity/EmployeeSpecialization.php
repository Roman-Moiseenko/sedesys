<?php
declare(strict_types=1);

namespace App\Modules\Employee\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $employee_id
 * @property int $specialization_id
 */
class EmployeeSpecialization extends Model
{
    public $timestamps = false;
    protected $table = 'employees_specializations';


}
