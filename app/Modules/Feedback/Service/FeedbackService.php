<?php

namespace App\Modules\Feedback\Service;

use App\Modules\Notification\Events\TelegramHasReceived;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use App\Modules\Notification\Message\StaffMessage;
use App\Modules\Order\Entity\Order;
use App\Modules\Order\Service\OrderService;
use App\Modules\User\Repository\UserRepository;
use App\Modules\User\Service\UserService;
use Illuminate\Http\Request;
use App\Modules\Feedback\Entity\Feedback;

class FeedbackService
{

    private OrderService $orderService;
    private UserRepository $users;

    public function __construct(OrderService $orderService, UserRepository $users,)
    {
        $this->orderService = $orderService;
        $this->users = $users;
    }

    public function create(Request $request): Feedback
    {

        $feedback = Feedback::register(
            $request->integer('id'),
        );

        $feedback->user = $request->string('user');
        $feedback->email = $request->string('email');
        $feedback->phone = $request->string('phone');
        $feedback->message = $request->string('message');

        $feedback->data = $request->except(['id', 'user', 'email', 'phone', 'message']);
        $feedback->save();

        return  $feedback;
    }


    public function destroy(Feedback $feedback)
    {
        /**
         * Проверить на возможность удаления
         */
        $feedback->delete();
    }

    /**
     * Слушаем событие - ответ из Телеграм. Обрабатываем ответ по взятию в работу заявки.
     * Подтверждение записи или отмена
     */
    public function handle(TelegramHasReceived $event): void
    {
        if ($event->operation == TelegramParams::OPERATION_FEEDBACK_TAKE) {
            /** @var Feedback $feedback */
            $feedback = Feedback::find($event->id);
            //Защита от повторного взятия
            if ($feedback->staff_id != null) { //Заявку уже взяли
                if ($feedback->staff_id == $event->user->id) { //Повторное нажатие
                    $event->user->notify(
                        new StaffMessage(
                            NotificationHelper::EVENT_ERROR,
                            'Вы уже подтвердили заявку!'
                        )
                    );
                } else { //Другой менеджер
                    $event->user->notify(
                        new StaffMessage(
                            NotificationHelper::EVENT_ERROR,
                            'Заявка была уже взята другим менеджером!'
                        )
                    );
                }
                return;
            }

            $feedback->setStaff($event->user->id);
            $event->user->notify(
                new StaffMessage(
                    NotificationHelper::EVENT_INFO,
                    'Принято!'
                )
            );
            //event(new RecordHasChangeStatus($calendar));
        }
    }

    public function createOrder(Feedback $feedback): Order
    {
        if (is_null($feedback->order_id)) {
            $order = $this->orderService->createByStaff(
                base: Order::BASE_FEEDBACK,
            );

            $feedback->order_id = $order->id;
            $feedback->status = Feedback::STATUS_COMPLETED;
            $feedback->save();

            //Если заполнен один из контактов, находим или создаем пользователя
            if ($feedback->phone != null || $feedback->email != null) {
                $user = $this->users->findOrCreate(
                    phone: $feedback->phone,
                    email: $feedback->email,
                    name: $feedback->user,
                );

                $order->setUser($user->id);
            }
        } else {
            $order = $feedback->order;
        }
        return $order;
    }
}
