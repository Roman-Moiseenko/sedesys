<?php

namespace App\Modules\Order\Entity;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Base\Entity\Photo;

use App\Modules\Base\Traits\HtmlInfoData;
use App\Modules\Discount\Entity\Coupon;
use App\Modules\User\Entity\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * @property int $id
 * @property int $user_id
 * @property int $staff_id
 * @property int $coupon_id //Скидочный купон
 * @property int $manual_discount //Ручная скидка, может null, а скидка берется с каждого товара отдельно
 * @property int $discount_id //Скидка на заказ - от суммы, или по дням, ... на будущее
 * @property int $base
 * @property string $number
 * @property string $comment
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property OrderStatus $status //текущий
 * @property OrderStatus[] $statuses
 * @property User $user
 * @property Admin $staff
 *
 * @property OrderService[] $orderServices
 * @property OrderExtra[] $orderExtras
 * @property OrderConsumable[] $orderConsumables
 * @property OrderPayment[] $orderPayments
 * @property Coupon $coupon
 */
class Order extends Model
{
    use HasFactory, HtmlInfoData;

    const BASE_FEEDBACK = 301;
    const BASE_CALENDAR = 302;
    const BASE_CART = 303;
    const BASE_OFFLINE = 304;
    const BASE_EMAIL = 305;
    const BASE_MESSAGE = 306;
    const BASE_PHONE = 307;

    const BASES = [
        self::BASE_FEEDBACK => 'Форма заявки',
        self::BASE_CALENDAR => 'По записи',
        self::BASE_CART => 'Корзина',
        self::BASE_OFFLINE => 'Ч/з кассу',
        self::BASE_EMAIL => 'По почте',
        self::BASE_MESSAGE => 'Через мессенджер',
        self::BASE_PHONE => 'По телефону',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'user_id',
        'base',
    ];

    public static function register(int|null $user_id, int $base): self
    {
        $order = self::create([
            'user_id' => $user_id,
            'base' => $base,
        ]);
        $order->statuses()->create(['value' => OrderStatus::FORMED]);
        return $order;
    }

    /**
     * Ф-ции состояния
     */

    /**
     * Статус $value был применен
     * @param int $value
     * @return bool
     */
    public function isStatus(#[ExpectedValues(valuesFromClass: OrderStatus::class)] int $value): bool
    {
        foreach ($this->statuses as $status) {
            if ($status->value == $value) return true;
        }
        return false;
    }

    ///***Проверка текущего статуса
    public function isNew(): bool
    {
        return $this->status->value == OrderStatus::FORMED;
    }

    public function isManager(): bool
    {
        return $this->status->value == OrderStatus::SET_MANAGER;
    }

    public function isAwaiting(): bool
    {
        return $this->status->value == OrderStatus::AWAITING;
    }

    public function isPrepaid(): bool
    {
        return $this->status->value == OrderStatus::PREPAID;
    }

    public function isPaid(): bool
    {
        return $this->status->value == OrderStatus::PAID;
    }

    public function InWork(): bool
    {
        return $this->status->value >= OrderStatus::PREPAID && $this->status->value < OrderStatus::CANCEL;
    }

    /**
     * Заказ оплачен полностью, но не завершен или отменен
     * @return bool
     */
    public function afterPaid(): bool
    {
        return $this->status->value > OrderStatus::PAID && $this->status->value < OrderStatus::CANCEL;
    }

    /*
        public function isToDelivery(): bool
        {
            return $this->status->value >= OrderStatus::ORDER_SERVICE && $this->status->value < OrderStatus::CANCEL;
        }
    */
    public function isCompleted(bool $only = false): bool
    {
        if ($only) return $this->status->value == OrderStatus::COMPLETED;
        return $this->status->value >= OrderStatus::COMPLETED;
    }

    public function isCanceled(): bool
    {
        return $this->status->value >= OrderStatus::CANCEL && $this->status->value < OrderStatus::COMPLETED;
    }

    /**
     * Сетеры
     */
    public function setStatus(
        #[ExpectedValues(valuesFromClass: OrderStatus::class)] int $value,
        string $comment = ''
    )
    {
        //if ($this->finished && $value != OrderStatus::COMPLETED_REFUND) throw new \DomainException('Заказ закрыт, статус менять нельзя');
        if ($this->isStatus($value)) throw new \DomainException('Статус уже назначен');
        if ($this->status->value > $value) throw new \DomainException('Нарушена последовательность статусов');

        $this->statuses()->create(['value' => $value, 'comment' => $comment]);

        if (in_array($value, [
            OrderStatus::CANCEL,
            OrderStatus::CANCEL_BY_CUSTOMER,
            OrderStatus::COMPLETED,
            OrderStatus::COMPLETED_REFUND,
            OrderStatus::REFUND
        ])) $this->update(['finished' => true]);
        if ($value == OrderStatus::PAID) $this->update(['paid' => true]);
    }

    public function setPaid()
    {
        $this->setStatus(OrderStatus::PAID);
        //$this->paid = true;
        $this->save();
        //Увеличиваем резерв на оплаченные товары
    }

    public function setStaff(int $staff_id)
    {
        //if ($this->staff_id != null) throw new \DomainException('Менеджер уже назначен, нельзя менять');
        if (!$this->isStatus(OrderStatus::SET_MANAGER)) $this->setStatus(OrderStatus::SET_MANAGER);
        $this->staff_id = $staff_id;
        $this->save();
    }

    public function setUser(int $user_id)
    {
        $this->user_id = $user_id;
        $this->save();
    }

    public function setNumber()
    {
        $count = Order::where('number', '<>', null)->count();
        $this->number = $count + 1;
        $this->save();
    }
    /**
     * Гетеры
     */
    /**
     * Доступные статусы для текущего заказа, ограниченные сверху
     * @param int $top_status
     * @return array
     */
    public function getAvailableStatuses(int $top_status = OrderStatus::COMPLETED): array
    {
        $last_code = $this->status->value;
        $result = [];
        foreach (OrderStatus::STATUSES as $code => $name) {
            if ($code > $last_code && $code < $top_status) {
                $result[$code] = $name;
            }
        }
        return $result;
    }

    /**
     * Отношения
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(OrderStatus::class, 'order_id', 'id')->latestOfMany();
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class, 'order_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(function ($user, $order) {
            $user->fullname->surname = 'Гость';
        });
    }

    public function orderServices(): HasMany
    {
        return $this->hasMany(OrderService::class, 'order_id', 'id');
    }

    public function orderExtras(): HasMany
    {
        return $this->hasMany(OrderExtra::class, 'order_id', 'id');
    }

    public function orderConsumables(): HasMany
    {
        return $this->hasMany(OrderConsumable::class, 'order_id', 'id');
    }

    public function orderPayments()
    {
        return $this->hasMany(OrderPayment::class, 'order_id', 'id');
    }

    public function getOrderService(int $id): OrderService
    {
        foreach ($this->orderServices as $orderService) {
            if ($orderService->id == $id) return $orderService;
        }
        throw new \DomainException('Неверная позиция в заказе');
    }

    public function getOrderExtra(int $id): OrderExtra
    {
        foreach ($this->orderExtras as $orderExtra) {
            if ($orderExtra->id == $id) return $orderExtra;
        }
        throw new \DomainException('Неверная позиция в заказе');
    }

    public function getOrderConsumable(int $id): OrderConsumable
    {
        foreach ($this->orderConsumables as $orderConsumable) {
            if ($orderConsumable->id == $id) return $orderConsumable;
        }
        throw new \DomainException('Неверная позиция в заказе');
    }


    //Сумма по заказу, скидки и др.
    public function getAmountBase($isService = null): float|int
    {
        $amount = 0;
        foreach ($this->getItems() as $item) {
            if (is_null($isService) || ($item->isService() == $isService))
                $amount += $item->costBase() * $item->getQuantity();
        }
        return $amount;
    }

    public function getAmountSell($isService = null): float|int
    {
        $amount = 0;
        foreach ($this->getItems() as $item) {
            if (is_null($isService) || ($item->isService() == $isService))
                $amount += $item->costSell() * $item->getQuantity();
        }

        if (!is_null($this->coupon_id) && $this->coupon->min > $amount) {
            $amount -= $this->coupon->bonus;
        }
        return $amount;
    }

    public function getAmountPayment(): float|int
    {
        $amount = 0;
        foreach ($this->orderPayments as $payment) {
            $amount += $payment->amount;
        }
        return $amount;
    }

    /**
     * @return array<OrderItem>
     */
    public function getItems(): array
    {
        /** @var OrderItem[] $items */
        $items = array_merge(
            $this->orderServices()->getModels(),
            $this->orderExtras()->getModels(),
            $this->orderConsumables()->getModels()
        );

        return $items;

    }


    /**
     * Хелперы и Интерфейсы
     */
}
