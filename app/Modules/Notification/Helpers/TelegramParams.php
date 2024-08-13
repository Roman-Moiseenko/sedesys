<?php
declare(strict_types=1);

namespace App\Modules\Notification\Helpers;

class TelegramParams
{
    public string $caption;
    public int $operation;
    public ?int $id;
  //  public int $type; //staff, employee

    //const TYPE_STAFF = 1;
    //const TYPE_EMPLOYEE = 2;

    //const OPERATION_TEST = -1;
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
        //$this->type = $type;
    }

    public static function encode(mixed $data): self
    {
        $params = new static();


        return $params;
    }

    public function toTelegram(): string
    {
        return json_encode([
            'operation' => $this->operation,
            'id' => $this->id
        ]);
    }
}
