<?php

namespace App\Modules\Calendar\Service;

use App\Modules\Base\Helpers\Version;
use App\Modules\Calendar\Events\RecordHasChangeStatus;
use App\Modules\Notification\Events\TelegramHasReceived;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use App\Modules\Notification\Message\StaffMessage;
use App\Modules\Order\Entity\Order;
use App\Modules\Order\Service\OrderService;
use App\Modules\User\Entity\User;
use App\Modules\User\Repository\UserRepository;
use App\Modules\User\Service\UserService;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Modules\Calendar\Entity\Calendar;

class CalendarService
{


    private UserRepository $users;
    private OrderService $orderService;

    public function __construct(UserRepository $users, OrderService $orderService,)
    {
        $this->users = $users;
        $this->orderService = $orderService;
    }

    public function create(Request $request): Calendar
    {
        //dd($request->date('date'));

        //  if ($request->date('date')->lt(now()->subDay())) throw new \DomainException('Неверная дата');
        $service_id = $request->integer('service_id');
        $phone = $request->string('phone');
        $name = $request->string('user');

        preg_match(
            '/\[(.+)\](.+)/',
            $request->string('time'),
            $match);
        $employee_id = (int)$match[1];
        $time = $match[2];

        $date = $request->date('date')->toDateString() . ' ' . $time;

        $user = $this->users->findOrCreate(
            phone: $phone, name: $name
        );
        $calendar = Calendar::register(
            $service_id,
            $user->id,
            Carbon::parse($date)
        );
        $calendar->comment = $request->string('comment')->trim()->value();
        $calendar->employee_id = $employee_id;
        $calendar->save();

        event(new RecordHasChangeStatus($calendar));

        return $calendar;
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
        }
    }

    public function createOrder(Calendar $calendar)
    {
        if (is_null($calendar->order_id)) {
            $order = $this->orderService->createByStaff(
                base: Order::BASE_CALENDAR,
            );
            $calendar->order_id = $order->id;
            $calendar->status = Calendar::RECORD_COMPLETED;
            $calendar->save();

            $order->setUser($calendar->user_id);
            $this->orderService->addOrderService(
                $order,
                $calendar->service_id,
                $calendar->employee_id
            );
        } else {
            $order = $calendar->order;
        }
        return $order;
    }


}
