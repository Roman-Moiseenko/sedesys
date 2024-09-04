<?php
declare(strict_types=1);

namespace App\Modules\Calendar\Notification;

use App\Modules\Calendar\Events\RecordHasChangeStatus;

class RecordUser
{
    public function __construct()
    {
        // ...
    }

    public function handle(RecordHasChangeStatus $event)
    {
        //TODO Уведомляем Клиента!!!!!!!
        // Только при создании заказа, отмене и подтверждению

        $calendar = $event->calendar;
        if ($calendar->isNew()) {
            $message = 'Ваш заказ получен и обрабатывается оператором';
        }

        if ($calendar->isCancel()) {
            $message = 'Ваш заказ был отменен';
        }

        if ($calendar->isConfirm()) {
            $message = 'Ваш заказ подтвержден';
        }


    }
}
