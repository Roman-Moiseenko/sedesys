<?php
declare(strict_types=1);

namespace App\Modules\Employee\Entity;

use App\Modules\Service\Entity\Example;
use Illuminate\Database\Eloquent\Model;
/**
 * @property int $employee_id
 * @property int $example_id
 * @property Employee $employee
 * @property Example $example
 */
class EmployeeExample extends Model
{
    public $timestamps = false;
    protected $table = 'employees_examples';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function example()
    {
        return $this->belongsTo(Example::class, 'example_id', 'id');
    }
}
