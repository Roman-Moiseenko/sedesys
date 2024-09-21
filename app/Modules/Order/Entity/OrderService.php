<?php
declare(strict_types=1);

namespace App\Modules\Order\Entity;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Entity\Service;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $service_id
 * @property int $employee_id
 * @property Service $service
 * @property Employee $employee
 */
class OrderService extends OrderItem
{
    protected $fillable = [
        'quantity',
        'service_id',
        'employee_id'
    ];

    public static function new(int $service_id,  int $employee_id, int $quantity = 1): self
    {
        return self::make([
            'quantity' => $quantity,
            'service_id' => $service_id,
            'employee_id' => $employee_id
        ]);
    }

    public function getName(): string
    {
        return $this->service->name;
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function isService(): bool
    {
        return true;
    }
}
