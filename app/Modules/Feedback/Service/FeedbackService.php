<?php

namespace App\Modules\Feedback\Service;

use App\Modules\Notification\Events\TelegramHasReceived;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use App\Modules\Notification\Message\StaffMessage;
use Illuminate\Http\Request;
use App\Modules\Feedback\Entity\Feedback;

class FeedbackService
{

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
}
