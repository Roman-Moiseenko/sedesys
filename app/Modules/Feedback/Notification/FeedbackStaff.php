<?php
declare(strict_types=1);

namespace App\Modules\Feedback\Notification;

use App\Modules\Admin\Entity\Responsibility;
use App\Modules\Admin\Repository\StaffRepository;
use App\Modules\Feedback\Events\FeedbackHasSend;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use App\Modules\Notification\Message\StaffMessage;

class FeedbackStaff
{
    private StaffRepository $repository;

    public function __construct(StaffRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(FeedbackHasSend $event): void
    {
        $feedback = $event->feedback;
        $event = NotificationHelper::EVENT_NEW_ORDER;
        $message = 'Новая заявка ' . $feedback->template->name . "\n";
        if (!empty($feedback->user)) $message .= $feedback->user . "\n";
        if (!empty($feedback->email)) $message .= $feedback->email . "\n";
        if (!empty($feedback->phone)) $message .= $feedback->phone . "\n";
        if (!empty($feedback->message)) $message .= $feedback->message . "\n";
        if (!empty($feedback->data)) $message .= json_encode($feedback->data) . "\n";

        $params = new TelegramParams(TelegramParams::OPERATION_FEEDBACK_TAKE, $feedback->id);

        $message .= $feedback->created_at->translatedFormat('d-m-Y H:i');

        $staffs = $this->repository->getActiveByResponsibility(Responsibility::MANAGER_FEEDBACK);

        foreach ($staffs as $staff) {
            $staff->notify(
                new StaffMessage(
                    event: $event,
                    message: $message,
                    params: $params,
                )
            );
        }
    }
}
