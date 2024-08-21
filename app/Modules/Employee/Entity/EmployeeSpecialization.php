<?php
declare(strict_types=1);

namespace App\Modules\Employee\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $employee_id
 * @property int $specialization_id
 * @property int $sort
 * @property Employee $employee
 * @property Specialization $specialization
 */
class EmployeeSpecialization extends Model
{
    public $timestamps = false;
    protected $table = 'employees_specializations';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id', 'id');
    }
}
