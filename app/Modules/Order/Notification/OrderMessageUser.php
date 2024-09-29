<?php
declare(strict_types=1);

namespace App\Modules\Order\Notification;

use App\Modules\Order\Events\OrderHasStatus;

class OrderMessageUser
{

    //TODO
    // Уведомления клиенту после блока обратная связь (чат, VK и др.)
    public function handle(OrderHasStatus $event): void
    {
        if ($event->order->isAwaiting()) {
            //Сформировать счет и отправить клиенту
            // или ссылку на оплату на телефон
        }
        if ($event->order->isPrepaid()) {
            //Отправка чека
        }
        if ($event->order->isPaid()) {
            //Отправка чека
            //Ваш заказ оплачен
        }
        if ($event->order->isCompleted()) {
            //Заказ завершен
        }
        if ($event->order->isCanceled()) {
            //Заказ отменен
        }
    }
}
