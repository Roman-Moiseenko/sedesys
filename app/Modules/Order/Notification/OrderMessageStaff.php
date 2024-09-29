<?php
declare(strict_types=1);

namespace App\Modules\Order\Notification;

use App\Modules\Admin\Entity\Responsibility;
use App\Modules\Admin\Repository\StaffRepository;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Message\StaffMessage;
use App\Modules\Order\Events\OrderHasStatus;

class OrderMessageStaff
{
    private StaffRepository $repository;

    public function __construct(StaffRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param OrderHasStatus $event
     * @return void
     */
    public function handle(OrderHasStatus $event): void
    {
        $order = $event->order;
        //На случай, если надо отправить всем
        //$staffs = $this->repository->getActiveByResponsibility(Responsibility::MANAGER_ORDER);
        $event = NotificationHelper::EVENT_PAYMENT;
        if ($order->isPrepaid()) {
            //Поступила предоплата
            $order->staff->notify(
                new StaffMessage(
                    event: $event,
                    message: 'Предоплата по заказу ' . $order->htmlNumDate() ,
                    //params: $params,
                )
            );
        }
        if ($order->isPaid()) {
            //Заказ полностью оплачен
            $order->staff->notify(
                new StaffMessage(
                    event: $event,
                    message: 'Заказ оплачен ' . $order->htmlNumDate() ,
                //params: $params,
                )
            );
        }

    }
}
