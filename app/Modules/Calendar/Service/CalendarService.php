<?php

namespace App\Modules\Calendar\Service;

use App\Modules\Base\Helpers\Version;
use App\Modules\Calendar\Events\RecordHasChangeStatus;
use App\Modules\Notification\Events\TelegramHasReceived;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use App\Modules\Notification\Message\StaffMessage;
use App\Modules\User\Entity\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Modules\Calendar\Entity\Calendar;

class CalendarService
{

    public function create(Request $request): Calendar
    {
        if ($request->date('date')->lte(now())) throw new \DomainException('Неверная дата');
        $service_id = $request->integer('service_id');
        $phone = $request->string('phone');
        $user = $request->string('user');

        preg_match(
            '/\[(.+)\](.+)/',
            $request->string('time'),
            $match);
        $employee_id = (int)$match[1];
        $time = $match[2];

        $date = $request->date('date')->toDateString() . ' ' . $time;

        $user = User::findToRecord($phone, $user);
        $calendar = Calendar::register(
            $service_id,
            $user->id,
            Carbon::parse($date)
        );
        $calendar->comment = $request->string('comment')->trim()->value();
        $calendar->employee_id = $employee_id;
        $calendar->save();

        event(new RecordHasChangeStatus($calendar));

        return  $calendar;
    }


    public function destroy(Calendar $calendar)
    {
        $version = (int)str_replace('.', '', Version::version) / 100;
        if ($version < 1) $calendar->delete();
    }

    /**
     * Слушаем событие - ответ из Телеграм. Обрабатываем ответ по записи от Персонала.
     * Подтверждение записи или отмена
     */
    public function handle(TelegramHasReceived $event): void
    {
        if ($event->operation == TelegramParams::OPERATION_RECORD_CONFIRM) {
            /** @var Calendar $calendar */
            $calendar = Calendar::find($event->id);
            $calendar->confirm();
            $event->user->notify(
                new StaffMessage(
                    NotificationHelper::EVENT_INFO,
                    'Принято!'
                )
            );
            event(new RecordHasChangeStatus($calendar));
        }

        if ($event->operation == TelegramParams::OPERATION_RECORD_CANCEL) {
            /** @var Calendar $calendar */
            $calendar = Calendar::find($event->id);
            $calendar->cancel();
            $event->user->notify(
                new StaffMessage(
                    NotificationHelper::EVENT_INFO,
                    'Принято!'
                )
            );

            event(new RecordHasChangeStatus($calendar));
        };


    }
}
