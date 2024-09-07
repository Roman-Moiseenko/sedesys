<?php
declare(strict_types=1);

namespace App\Modules\Calendar\Notification;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Calendar\Events\RecordHasChangeStatus;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use App\Modules\Notification\Message\StaffMessage;

class RecordStaff
{
    public function __construct()
    {
        // ...
    }

    public function handle(RecordHasChangeStatus $event)
    {
        $calendar = $event->calendar;
        $event = NotificationHelper::EVENT_TEST;
        $message = 'Случилась какая-то фигня.';

        if ($calendar->isNew()) {
            $event = NotificationHelper::EVENT_NEW_ORDER;
            $message = 'Запись на ' . $calendar->service->name . "\n" .
                $calendar->employee->fullname->getFullName() . "\n" .
                $calendar->getDate() . ' ' . $calendar->getTime();

        }

        if ($calendar->isCancel()) {
            $event = NotificationHelper::EVENT_ORDER_CANCEL;
            $message = 'Запись отменена на ' . $calendar->service->name . "\n" .
                $calendar->employee->fullname->getFullName() . "\n" .
                $calendar->getDate() . ' ' . $calendar->getTime();
        }

        //TODO После добавления уровня доступа выбирать, тех, кто принимает заявки
        $staffs = Admin::get(); //Выбрать "Администратора Ресепшина"
        foreach($staffs as $staff) {
            $staff->notify(
                new StaffMessage(
                    event: $event,
                    message: $message,
                    telegram: false,
                    database: true
                )
            );
        }
    }
}
