<?php
declare(strict_types=1);

namespace App\Modules\Order\Entity;


use App\Modules\Discount\Entity\Promotion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

/**
 * @property int $id
 * @property int $order_id
 * @property int $base_cost - базовая цена, не меняется
 * @property int $sell_cost - цена продажи, со скидкой, можно ставить вручную
 * @property int $quantity
 * @property int $promotion_id
 * @property string $comment
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Order $order
 * @property Promotion $promotion
 */

abstract class OrderItem extends Model
{
    protected $touches = [
        'order',
    ];

    public function costBase(): int
    {
        return $this->base_cost;
    }

    public function costSell(): int
    {
        return $this->sell_cost;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setSellCost(int $sell): bool
    {
        $result = false;
        if ($sell > $this->base_cost) throw new \DomainException('Цена не может быть выше базовой');
        if ($sell > 0 && $sell != $this->sell_cost) {
            $this->sell_cost = $sell;
            $this->save();
            $result = true;
        }
        return $result;
    }

    public function setQuantity(int $quantity): bool
    {
        $result = false;
        if ($quantity > 0 && $quantity != $this->quantity) {
            $this->quantity = $quantity;
            $this->save();
            $result = true;
        }
        return $result;
    }

    public function setComment(string $comment): bool
    {
        $result = false;
        if (!empty($comment) && $comment != $this->comment) {
            $this->comment = $comment;
            $this->save();
            $result = true;
        }
        return $result;
    }

    final public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    final public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id', 'id');
    }

    abstract public function getName(): string;

    abstract public function isService(): bool;

    //Для создания таблиц
    final public static function columns(Blueprint $table)
    {
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        $table->foreignId('promotion_id')->nullable()->constrained('promotions')->onDelete('set null');

        $table->integer('base_cost');
        $table->integer('sell_cost');
        $table->integer('quantity');
        $table->string('comment')->default('');
        $table->timestamps();

    }

    final public static function dropColumns(Blueprint $table)
    {
        $table->dropForeign(['order_id']);
        $table->dropForeign(['promotion_id']);
        $table->dropColumn('order_id');
        $table->dropColumn('promotion_id');

        $table->dropColumn('base_cost');
        $table->dropColumn('sell_cost');
        $table->dropColumn('quantity');
        $table->dropColumn('comment');

        $table->dropColumn('created_at');
        $table->dropColumn('updated_at');

    }
}
