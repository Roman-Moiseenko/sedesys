<?php
declare(strict_types=1);

namespace App\Modules\Calendar\Notification;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Calendar\Events\RecordHasChangeStatus;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use App\Modules\Notification\Message\StaffMessage;

class RecordEmployee
{
    public function __construct()
    {
        // ...
    }

    public function handle(RecordHasChangeStatus $event): void
    {
        $calendar = $event->calendar;

        if ($calendar->isNew()) {
            $params = [
                new TelegramParams(TelegramParams::OPERATION_RECORD_CONFIRM, $calendar->id),
                new TelegramParams(TelegramParams::OPERATION_RECORD_CANCEL, $calendar->id)
            ];
            $event = NotificationHelper::EVENT_NEW_ORDER;
            $message = 'Запись на ' . $calendar->service->name . "\n" . $calendar->getDate() . ' ' . $calendar->getTime();

        }
        if ($calendar->isCancel()) {
            $event = NotificationHelper::EVENT_ORDER_CANCEL;
            $message = 'Запись на ' . $calendar->service->name . "\n" . $calendar->getDate() . ' ' . $calendar->getTime() . ' Была отменена';
        }
        $calendar->employee->notify(
            new StaffMessage(
                event: $event,
                message: $message,
                params: $params ?? null
            )
        );

    }
}
