<?php
declare(strict_types=1);

namespace App\Modules\Order\Entity;

use App\Modules\Service\Entity\Extra;

/**
 * @property int $extra_id
 * @property Extra $extra
 */
class OrderExtra extends OrderItem
{
    protected $fillable = [
        'quantity',
        'extra_id',
    ];

    public static function new(int $extra_id, int $quantity = 1): self
    {
        return self::make([
            'quantity' => $quantity,
            'extra_id' => $extra_id,
        ]);
    }


    public function getName(): string
    {
        return $this->extra->name;
    }

    public function extra()
    {
        return $this->belongsTo(Extra::class, 'extra_id', 'id');
    }

    public function isService(): bool
    {
        return true;
    }
}
