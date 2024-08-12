<?php

namespace App\Modules\Notification\Service;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Message\EmployeeMessage;
use App\Modules\Notification\Message\StaffMessage;
use Illuminate\Http\Request;
use App\Modules\Notification\Entity\Notification;
use JetBrains\PhpStorm\Deprecated;

class NotificationService
{

    public function create(Request $request)
    {

        $staff_ids = $request->input('staffs');
        $employee_ids = $request->input('employees');
        $message = $request->string('message')->trim()->value();


        foreach ($staff_ids as $staff_id) {
            /** @var Admin $staff */
            $staff = Admin::find($staff_id);
            $staff->notify(
                new StaffMessage(
                    NotificationHelper::EVENT_CHIEF,
                    $message
                )
            );
        }

        foreach ($employee_ids as $employee_id) {
            /** @var Employee $employee */
            $employee = Employee::find($employee_id);
            $employee->notify(
                new EmployeeMessage(
                    NotificationHelper::EVENT_CHIEF,
                    $message
                )
            );
        }


    }


    #[Deprecated]
    public function update(Notification $notification, Request $request)
    {
        /**
         * Сохраняем базовые поля
         */
        $notification->name = $request->string('name')->trim()->value();
        $notification->save();

        $this->save_fields($notification, $request);
    }
    #[Deprecated]
    private function save_fields(Notification $notification, Request $request)
    {
        /**
         * Сохраняем оставшиеся поля
         */

        $notification->save();
    }

    #[Deprecated]
    public function destroy(Notification $notification)
    {
        /**
         * Проверить на возможность удаления
         */
        $notification->delete();
    }
}
