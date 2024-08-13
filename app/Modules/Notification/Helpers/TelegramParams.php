<?php
declare(strict_types=1);

namespace App\Modules\Notification\Helpers;
/**
 * Параметры для callback
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

    const OPERATIONS = [
        self::OPERATION_READ => 'Прочитано', //Staff и Employee
        self::OPERATION_TAKE_ORDER => 'Взять заказ', //Employee
        self::OPERATION_PAYMENT => 'Оплата получена',
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
