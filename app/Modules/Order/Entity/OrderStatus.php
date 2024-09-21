<?php
declare(strict_types=1);

namespace App\Modules\Order\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $order_id
 * @property int $value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $comment
 *
 */

class OrderStatus extends Model
{
    const DRAFT = 199; //Резерв нет --- ????

    const FORMED = 200; //Резерв 1ч
    const SET_MANAGER = 201; //В работе у менеджера
    const AWAITING = 202; //Ожидает оплаты - резерв 3 дня ??????
    const PREPAID = 203;  //Предоплата
    const PAID = 204;  //Оплачен

    ///Выдача
    const READY = 260;// 'Готов к выдаче'
    const COMPLETED = 290; //Выдан (завершен)
    const COMPLETED_REFUND = 291; //Выдан частично, с возвратом части товара (завершен)

    ///Отмененные статусы
    const CANCEL = 280;//
    const CANCEL_BY_CUSTOMER = 281;//
    const REFUND = 282; //Возврат денег

    const STATUSES = [
        self::FORMED => 'Сформирован',
        self::SET_MANAGER => 'В работе у менеджера',
        self::AWAITING => 'Ожидает оплаты',
        self::PREPAID => 'Внесена предоплата',
        self::PAID => 'Оплачен',

        self::COMPLETED => 'Завершен',
        self::COMPLETED_REFUND => 'Завершен с возвратом',
        self::CANCEL => 'Отменен',
        self::CANCEL_BY_CUSTOMER => 'Отменен клиентом',
        self::REFUND => 'Возврат оплаты',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'order_id',
        'value',
        'comment'
    ];


    public function value(): string
    {
        return self::STATUSES[$this->value];
    }
}
