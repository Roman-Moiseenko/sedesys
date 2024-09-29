<?php

namespace App\Modules\Order\Service;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Base\Helpers\RequestMessage;
use App\Modules\Discount\Entity\Coupon;
use App\Modules\Order\Entity\OrderConsumable;
use App\Modules\Order\Entity\OrderExtra;
use App\Modules\Order\Entity\OrderHistory;
use App\Modules\Order\Entity\OrderItem;
use App\Modules\Order\Entity\OrderPayment;
use App\Modules\Order\Entity\OrderStatus;
use App\Modules\Order\Events\OrderHasAwaiting;
use App\Modules\Order\Events\OrderHasStatus;
use App\Modules\Service\Entity\Consumable;
use App\Modules\Service\Entity\Extra;
use App\Modules\Service\Entity\Service;
use Illuminate\Http\Request;
use App\Modules\Order\Entity\Order;
use Illuminate\Support\Facades\Auth;
use App\Modules\Order\Entity\OrderService as OrderItemService;
use JetBrains\PhpStorm\Pure;

class OrderService
{

    public function createByStaff(int $base, int $user_id = null): Order
    {
        /** @var Admin $staff */
        $staff = Auth::guard('admin')->user();
        $order = Order::register(null, $base);
        $order->setStaff($staff->id);

        if (!is_null($user_id)) {
            $order->user_id = $user_id;
            $order->save();
        }
        $order->addHistory('Заказ создан менеджером');
        return $order;
    }

    public function create(Request $request): Order
    {
        $order = Order::register(
            $request->input('user_id'),
            $request->input('base'),
        );
        $order->addHistory('Заказ создан клиентом');
        return $order;
    }

    //OrderService
    public function serviceAdd(Order $order, Request $request): string
    {
        $request->validate([
            'service_id' => ['required',],
            'employee_id' => ['required',],
            'quantity' => ['min:1']
        ],
            RequestMessage::messages()
        );

        try {
            $this->addOrderService(
                $order,
                $request->integer('service_id'),
                $request->integer('employee_id'),
                $request->integer('quantity')
            );
            return 'Услуга добавлена в заказ';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Для создания заказа из Calendar
     * @param Order $order
     * @param int $service_id
     * @param int $employee_id
     * @param int $quantity
     * @return void
     */
    public function addOrderService(Order $order, int $service_id, int $employee_id, int $quantity = 1)
    {
        $service = Service::find($service_id);

        $order_service = OrderItemService::new(
            $service->id,
            $employee_id,
            $quantity,
        );

        $order_service->base_cost = ($service->price + $service->extra_cost($employee_id));
        if (!is_null($promotion = $service->getPromotion())) {
            $order_service->sell_cost = ($promotion->pivot->price + $service->extra_cost($employee_id));
            $order_service->promotion_id = $promotion->id;
        } else {
            $order_service->sell_cost = $order_service->base_cost;
        }
        $order->orderServices()->save($order_service);

        $order->addHistory(
            'Добавлена услуга',
            $service->name,
            $this->valueText($order_service),
            route('admin.service.service.show', $service)
        );
    }

    public function serviceSet(Order $order, Request $request): string
    {
        try {
            $orderService = $order->getOrderService($request->integer('id'));

            if ($orderService->setSellCost($request->integer('sell_cost'))) {
                $order->addHistory(
                    'Изменена цена на услугу',
                    $orderService->service->name,
                    $request->integer('sell_cost'),
                    route('admin.service.service.show', $orderService->service));
            }
            if ($orderService->setQuantity($request->integer('quantity'))) {
                $order->addHistory(
                    'Изменено кол-во услуги',
                    $orderService->service->name,
                    $request->integer('quantity'),
                    route('admin.service.service.show', $orderService->service));
            }
            if ($orderService->setComment($request->string('comment'))) {
                $order->addHistory(
                    'Изменен комментарий для услуги',
                    $orderService->service->name,
                    $request->integer('comment'),
                    route('admin.service.service.show', $orderService->service));
            }

            return 'Сохранено';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    public function serviceDel(Order $order, Request $request): string
    {
        $orderService = $order->getOrderService($request->integer('id'));
        $order->addHistory(
            action: 'Удалена услуга',
            object: $orderService->service->name,
            url: route('admin.service.service.show', $orderService->service));

        $order->orderServices()->where('id', $request->integer('id'))->delete();
        return 'Удалено';
    }

    //OrderExtra
    public function extraAdd(Order $order, Request $request): string
    {
        $request->validate([
            'extra_id' => ['required',],
            'quantity' => ['min:1']
        ],
            RequestMessage::messages()
        );
        try {
            /** @var Extra $extra */
            $extra = Extra::find($request->integer('extra_id'));
            $quantity = $request->integer('quantity');
            $order_extra = OrderExtra::new($extra->id, $quantity);
            $order_extra->base_cost = $extra->price;
            $order_extra->sell_cost = $extra->price;
            $order->orderExtras()->save($order_extra);
            $order->addHistory(
                'Добавлена доп.услуга',
                $extra->name,
                $this->valueText($order_extra),
                route('admin.service.service.show', $extra->service->name)
            );
            return 'Доп.услуга добавлена в заказ';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }

    }

    public function extraSet(Order $order, Request $request): string
    {
        try {
            $orderExtra = $order->getOrderExtra($request->integer('id'));

            if ($orderExtra->setSellCost($request->integer('sell_cost'))) {
                $order->addHistory(
                    'Изменена цена на доп.услугу',
                    $orderExtra->extra->name,
                    $request->integer('sell_cost'),
                    route('admin.service.service.show', $orderExtra->extra->service));
            }
            if ($orderExtra->setQuantity($request->integer('quantity'))) {
                $order->addHistory(
                    'Изменено кол-во на доп.услуг',
                    $orderExtra->extra->name,
                    $request->integer('quantity'),
                    route('admin.service.service.show', $orderExtra->extra->service));
            }
            if ($orderExtra->setComment($request->string('comment'))) {
                $order->addHistory(
                    'Изменен комментарий доп.услуги',
                    $orderExtra->extra->name,
                    $request->integer('comment'),
                    route('admin.service.service.show', $orderExtra->extra->service));
            }

            return 'Сохранено';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    public function extraDel(Order $order, Request $request): string
    {
        $orderExtra = $order->getOrderExtra($request->integer('id'));
        $order->addHistory(
            action: 'Удалена доп.услуга',
            object: $orderExtra->extra->name,
            url: route('admin.service.service.show', $orderExtra->extra->service));
        $order->orderExtras()->where('id', $request->integer('id'))->delete();
        return 'Удалено';
    }

    //OrderConsumable
    public function consumableAdd(Order $order, Request $request): string
    {
        $request->validate([
            'consumable_id' => ['required',],
            'quantity' => ['min:1']
        ],
            RequestMessage::messages()
        );
        try {
            /** @var Consumable $consumable */
            $consumable = Consumable::find($request->integer('consumable_id'));
            $quantity = $request->integer('quantity');
            $order_consumable = OrderConsumable::new($consumable->id, $quantity);
            $order_consumable->base_cost = $consumable->price;
            $order_consumable->sell_cost = $consumable->price;
            $order->orderConsumables()->save($order_consumable);
            $order->addHistory(
                'Материал добавлен',
                $consumable->name,
                $this->valueText($order_consumable),
                route('admin.service.consumable.show', $consumable)
            );
            return 'Материал добавлен в заказ';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    public function consumableSet(Order $order, Request $request): string
    {
        try {
            $orderConsumable = $order->getOrderConsumable($request->integer('id'));

            if ($orderConsumable->setSellCost($request->integer('sell_cost'))) {
                $order->addHistory(
                    'Изменена цена на материал',
                    $orderConsumable->consumable->name,
                    $request->integer('sell_cost'),
                    route('admin.service.consumable.show', $orderConsumable->consumable));
            }
            if ($orderConsumable->setQuantity($request->integer('quantity'))) {
                $order->addHistory(
                    'Изменено кол-во материала',
                    $orderConsumable->consumable->name,
                    $request->integer('quantity'),
                    route('admin.service.consumable.show', $orderConsumable->consumable));
            }
            if ($orderConsumable->setComment($request->string('comment'))) {
                $order->addHistory(
                    'Изменен комментарий материала',
                    $orderConsumable->consumable->name,
                    $request->integer('comment'),
                    route('admin.service.consumable.show', $orderConsumable->consumable));
            }

            return 'Сохранено';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    public function consumableDel(Order $order, Request $request): string
    {
        $orderConsumable = $order->getOrderConsumable($request->integer('id'));
        $order->addHistory(
            action: 'Удален материал',
            object: $orderConsumable->consumable->name,
            url: route('admin.service.consumable.show', $orderConsumable->consumable));
        $order->orderConsumables()->where('id', $request->integer('id'))->delete();
        return 'Удалено';
    }

    #[Pure]
    private function valueText(OrderItem $item): string
    {
        return 'баз.цена ' . $item->costBase() .
            ' прод.цена ' . $item->costSell() .
            ' кол-во ' . $item->getQuantity();
    }

    public function destroy(Order $order)
    {
        if ($order->isNew() || $order->isManager()) {
            $order->delete();
        } else {
            throw new \DomainException('Заказ в работе. Удалить нельзя');
        }
    }

    public function setAwaiting(Order $order)
    {
        if ($order->getAmountSell() == 0) throw new \DomainException('Сумма заказа не может быть равно нулю');
        $order->setNumber();
        $order->setStatus(OrderStatus::AWAITING);
        $order->addHistory(
            action: 'Выставлен счет',
            object: 'Счет',
        //TODO
        // url: route('admin.service.order.invoice', $order) Ссылка на счет
        );
        event(new OrderHasStatus($order));
    }

    /**
     * Установить купон
     * @param Order $order
     * @param Request $request
     * @return void
     */
    public function set_coupon(Order $order, Request $request)
    {
        $code = $request->string('coupon')->value();
        /** @var Coupon $coupon */
        $coupon = Coupon::where('code', $code)->first();
        if ($coupon->user_id != $order->user_id) throw new \DomainException('Купон привязан к другому клиенту');
        if (!$coupon->isNew()) throw new \DomainException('Купон привязан к другому заказу');

        if (!is_null($coupon->finished_at) && $coupon->finished_at->lt(now()))
            throw new \DomainException('Купон просрочен');
        $order->coupon_id = $coupon->id;
        $order->save();
        $coupon->assigned();
        $order->addHistory(
            action: 'Назначен купон',
            object: 'Код ' . $code,
            value: $coupon->bonus . ' ₽',
        );
    }

    /**
     * Удалить купон
     * @param Order $order
     * @return void
     */
    public function del_coupon(Order $order)
    {
        if (!is_null($order->coupon_id)) return;
        if (!$order->isManager()) throw new \DomainException('Купон используется в расчете, удалить нельзя!');
        $order->coupon->status = Coupon::NEW;
        $order->coupon->save();
        $order->coupon_id = null;
        $order->save();
        $order->addHistory(
            action: 'Удален купон',
        );
    }

    /**
     * Проверка Заказа после поступления оплаты, смена статуса, генерация события
     * @param Order $order
     * @return void
     */
    public function check_payment(Order $order)
    {
        if ($order->getAmountSell() <= $order->getAmountPayment()) {
            $order->setPaid();
        } else {

            if ($order->isAwaiting()) {
                $order->setStatus(OrderStatus::PREPAID);
            }
            if ($order->getAmountPayment() == 0 && !$order->isAwaiting()) {

                $order->addHistory(
                    action: 'Удалены все платежи.',
                );
                //Для удаления ошибочных платежей
                foreach ($order->statuses as $status) {
                    if ($status->value > OrderStatus::AWAITING) $status->delete();
                }
            }
        }
        event(new OrderHasStatus($order));
        //Если купон в заказе, то завершаем его использование
        if (!is_null($order->coupon_id) && !$order->coupon->isUsed()) {
            $order->coupon->used();
        }
    }

    public function paid(Order $order, Request $request)
    {
        if ($order->getAmountSell() == 0) throw new \DomainException('Сумма заказа не может быть равно нулю');

        if ($order->isManager()) {
            $order->setNumber();
            $order->setStatus(OrderStatus::AWAITING);
        }

        /** @var Admin $staff */
        $staff = Auth::guard('admin')->user();
        $payment = OrderPayment::register(
            $order->id,
            $request->integer('amount'),
            $request->integer('method'),
        );
        $payment->staff_id = $staff->id;
        $payment->document = '';
        $payment->save();

        $order->addHistory(
            action: 'Поступила оплата',
            object: 'Внесена менеджером',
            value: $payment->amount,
            url: route('admin.order.payment.show', $payment)
        );
        $order->refresh();
        $this->check_payment($order);
    }

    public function cheque(Order $order)
    {

        if ($order->getAmountSell() == 0) throw new \DomainException('Сумма заказа не может быть равно нулю');

        if ($order->isManager()) {
            $order->setNumber();
            $order->setStatus(OrderStatus::AWAITING);
        }
        //TODO Пробитие чека, получаем №документа
        $document = 'document';
        $amount = $order->getAmountSell() - $order->getAmountPayment();



        /** @var Admin $staff */
        $staff = Auth::guard('admin')->user();
        $payment = OrderPayment::register(
            $order->id,
            $amount,
            OrderPayment::METHOD_CASH,
        );
        $payment->staff_id = $staff->id;
        $payment->document = $document;
        $payment->save();

        $order->addHistory(
            action: 'Пробит чек',
            object: 'Чек',
            value: $amount,
            url: route('admin.order.payment.show', $payment)
        );
        $order->refresh();
        $this->check_payment($order);

    }
}
