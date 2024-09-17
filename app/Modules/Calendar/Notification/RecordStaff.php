<?php
declare(strict_types=1);

namespace App\Modules\Calendar\Notification;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Admin\Entity\Responsibility;
use App\Modules\Admin\Repository\StaffRepository;
use App\Modules\Calendar\Events\RecordHasChangeStatus;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use App\Modules\Notification\Message\StaffMessage;

class RecordStaff
{
    private StaffRepository $repository;

    public function __construct(StaffRepository $repository)
    {
        $this->repository = $repository;
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

        $staffs = $this->repository->getActiveByResponsibility(Responsibility::MANAGER_RECORD); //Выбрать "Администратора Ресепшина"
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
