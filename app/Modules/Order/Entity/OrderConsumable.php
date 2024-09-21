<?php
declare(strict_types=1);

namespace App\Modules\Order\Entity;

use App\Modules\Service\Entity\Consumable;

/**
 * @property int $consumable_id
 * @property Consumable $consumable
 */
class OrderConsumable extends OrderItem
{
    protected $fillable = [
        'quantity',
        'consumable_id',
    ];

    public static function new(int $consumable_id, int $quantity = 1): self
    {
        return self::make([
            'quantity' => $quantity,
            'consumable_id' => $consumable_id,
        ]);
    }

    public function getName(): string
    {
        return $this->consumable->name;
    }

    public function consumable()
    {
        return $this->belongsTo(Consumable::class, 'consumable_id', 'id');
    }

    public function isService(): bool
    {
        return false;
    }
}
