<?php
declare(strict_types=1);

namespace App\Modules\Notification\Helpers;
/**
 * Параметры для callback от чат-бота Телеграм
 * OPERATION_... - операция произведенная клиентов в чат-боте
 */
class TelegramParams
{
    public string $caption;
    public int $operation;
    public ?int $id;

    const OPERATION_READ = 101;
    const OPERATION_TAKE_ORDER = 102;
    const OPERATION_PAYMENT = 103;
    const OPERATION_RECORD_CONFIRM = 104;
    const OPERATION_RECORD_CANCEL = 105;

    const OPERATIONS = [
        self::OPERATION_READ => 'Прочитано', //Staff и Employee
        self::OPERATION_TAKE_ORDER => 'Взять заказ', //Employee
        self::OPERATION_PAYMENT => 'Оплата получена',
        self::OPERATION_RECORD_CONFIRM => 'Подтвердить запись',
        self::OPERATION_RECORD_CANCEL => 'Отменить запись',
    ];

    public function __construct(int $operation = null, int $id = null)
    {
        $this->caption = is_null($operation) ? '' : self::OPERATIONS[$operation];
        $this->operation = $operation;
        $this->id = $id;
    }

    public function toTelegram(): string
    {
        return json_encode([
            'operation' => $this->operation,
            'id' => $this->id
        ]);
    }
}
