<?php

namespace App\Modules\Order\Service;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Base\Helpers\RequestMessage;
use App\Modules\Order\Entity\OrderConsumable;
use App\Modules\Order\Entity\OrderExtra;
use App\Modules\Order\Entity\OrderStatus;
use App\Modules\Order\Events\OrderHasAwaiting;
use App\Modules\Service\Entity\Consumable;
use App\Modules\Service\Entity\Extra;
use App\Modules\Service\Entity\Service;
use Illuminate\Http\Request;
use App\Modules\Order\Entity\Order;
use Illuminate\Support\Facades\Auth;
use App\Modules\Order\Entity\OrderService as OrderItemService;

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

        return $order;
    }

    public function create(Request $request): Order
    {
        return Order::register(
            $request->input('user_id'),
            $request->input('base'),
        );
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
    }

    public function serviceSet(Order $order, Request $request): string
    {
        try {
            $orderService = $order->getOrderService($request->integer('id'));

            $orderService->setSellCost($request->integer('sell_cost'));
            $orderService->setQuantity($request->integer('quantity'));
            $orderService->setComment($request->string('comment'));

            return 'Сохранено';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    public function serviceDel(Order $order, Request $request): string
    {
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

            return 'Доп.услуга добавлена в заказ';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }

    }

    public function extraSet(Order $order, Request $request): string
    {
        try {
            $orderExtra = $order->getOrderExtra($request->integer('id'));

            $orderExtra->setSellCost($request->integer('sell_cost'));
            $orderExtra->setQuantity($request->integer('quantity'));
            $orderExtra->setComment($request->string('comment'));

            return 'Сохранено';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    public function extraDel(Order $order, Request $request): string
    {
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

            return 'Материал добавлен в заказ';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    public function consumableSet(Order $order, Request $request): string
    {
        try {
            $orderConsumable = $order->getOrderConsumable($request->integer('id'));

            $orderConsumable->setSellCost($request->integer('sell_cost'));
            $orderConsumable->setQuantity($request->integer('quantity'));
            $orderConsumable->setComment($request->string('comment'));

            return 'Сохранено';
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    public function consumableDel(Order $order, Request $request): string
    {
        $order->orderConsumables()->where('id', $request->integer('id'))->delete();
        return 'Удалено';
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
        if ($order->getAmountSell() == 0)  throw new \DomainException('Сумма заказа не может быть равно нулю');
        $order->setNumber();
        $order->setStatus(OrderStatus::AWAITING);
        event(new OrderHasAwaiting($order));
    }
}
