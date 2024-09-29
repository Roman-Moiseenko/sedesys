<?php

namespace App\Modules\Order\Repository;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Order\Entity\OrderConsumable;
use App\Modules\Order\Entity\OrderExtra;
use App\Modules\Order\Entity\OrderService;
use App\Modules\Order\Entity\OrderStatus;
use App\Modules\Service\Entity\Consumable;
use App\Modules\Service\Entity\Extra;
use App\Modules\Service\Entity\Service;
use App\Modules\User\Repository\UserRepository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Order\Entity\Order;

class OrderRepository
{

    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Order::orderByDesc('created_at');
        $filters = [];
        if ($request->has('user')) {
            $user = $request->string('user')->trim()->value();
            $filters['user'] = $user;
            $query->whereHas('order', function ($query) use ($user) {
                $query->whereHas('user', function ($query) use ($user) {
                    $query->whereRaw("LOWER(fullname) like LOWER('%$user%')")
                        ->orWhere('phone', 'LIKE', "%$user%")
                        ->orWhere('email', 'LIKE', "%$user%");
                });
            });
        }
        if ($request->has('staff')) {
            $staff = $request->integer('staff');
            $filters['staff'] = $staff;
            $query->where('staff_id', $staff);
        }

        if ($request->input('status')) {
            $status = $request->integer('status');
            $filters['status'] = $status;
            $query->whereHas('status', function ($query) use ($status) {
                $query->where('value', $status);
            });
        }

        if (!is_null($request->input('date_from'))) {
            $date_from = $request->date('date_from');
            $filters['date_from'] = $request->input('date_from');
            $query->where('created_at', '>=', $date_from);
        }
        if (!is_null($request->input('date_to'))) {
            $date_to = $request->date('date_to');
            $filters['date_to'] = $request->input('date_to');
            $query->where('created_at', '<=', $date_to);
        }

        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Order $order) => $this->OrderToArray($order));
    }


    public function OrderToArray(Order $order): array
    {
        return [
            'id' => $order->id,
            'number' => $order->htmlNum(),
            'created_at' => $order->htmlDate(),
            'name' => $order->htmlNumDate(),
            'user' => $order->user,
            'comment' => $order->comment,
            'amount' => $order->getAmountSell(),
            'status' => [
                'text' => $order->status->value(),
                'new' => $order->isNew(),
                'manager' => $order->isManager(),
                'awaiting' => $order->isAwaiting(),
                'prepaid' => $order->isPrepaid(),
                'paid' => $order->isPaid(),
                'cancel' => $order->isCanceled(),
                'completed' => $order->isCompleted(),
                'date' => $order->status->created_at->format('d-m-Y H:i')

            ],
            'info' => [
                'amount_base' => $order->getAmountBase(),
                'amount_sell' => $order->getAmountSell(),

                'services_base' => $order->getAmountBase(true),
                'services_sell' => $order->getAmountSell(true),
                'goods_base' => $order->getAmountBase(false),
                'goods_sell' => $order->getAmountSell(false),

                'amount_payment' => $order->getAmountPayment(),
                'count_services' => 0, //услуги
                'count_goods' => 0, //товары
            ],
        ];
    }

    public function OrderWithToArray(Order $order): array
    {
        $withData = [
            'services' => $order->orderServices()->get()->map(fn(OrderService $orderService) => [
                'id' => $orderService->id,
                'service' => $orderService->service->name,
                'employee' => $orderService->employee->fullname->getShortname(),
                'promotion' => is_null($orderService->service->getPromotion()) ? null : $orderService->service->getPromotion()->name,
                'base_cost' => $orderService->base_cost,
                'sell_cost' => $orderService->sell_cost,
                'quantity' => $orderService->quantity,
                'comment' => $orderService->comment,
            ])->toArray(),

            'extras' => $order->orderExtras()->get()->map(fn(OrderExtra $orderExtra) => [
                'id' => $orderExtra->id,
                'extra' => $orderExtra->extra->name,
                'base_cost' => $orderExtra->base_cost,
                'sell_cost' => $orderExtra->sell_cost,
                'quantity' => $orderExtra->quantity,
                'comment' => $orderExtra->comment,
            ])
                ->toArray(),
            'consumables' => $order->orderConsumables()->get()->map(fn(OrderConsumable $orderConsumable) => [
                'id' => $orderConsumable->id,
                'consumable' => $orderConsumable->consumable->name,
                'base_cost' => $orderConsumable->base_cost,
                'sell_cost' => $orderConsumable->sell_cost,
                'quantity' => $orderConsumable->quantity,
                'comment' => $orderConsumable->comment,
            ])->toArray(),

            'user' => is_null($order->user_id) ? null : $this->users->UserToArray($order->user),

            /**
             * Данные из relations
             */
        ];

        return array_merge($this->OrderToArray($order), $withData);
    }

    public function ServicesOut(Order $order): array
    {
        $_ids = $order->orderServices()->pluck('service_id')->toArray();

        return Service::orderBy('name')
            ->active()
            ->whereNotIn('id', $_ids)
            ->get()
            ->map(fn(Service $service) => [
                'id' => $service->id,
                'name' => $service->name,
                'employees' => $service->employees()->get()->map(fn(Employee $employee) => [
                    'id' => $employee->id,
                    'name' => $employee->fullname->getFullName(),
                    'extra_cost' => $employee->pivot->extra_cost,
                ])
            ])
            ->toArray();
    }

    public function ConsumablesOut(Order $order): array
    {
        $_ids = $order->orderConsumables()->pluck('consumable_id')->toArray();

        return Consumable::orderBy('name')
            ->active()
            ->whereNotIn('id', $_ids)
            ->get()
            ->map(fn(Consumable $consumable) => [
                'id' => $consumable->id,
                'name' => $consumable->name,
                'price' => $consumable->price,
            ])
            ->toArray();
    }

    public function ExtrasOut(Order $order): array
    {
        $_ids = $order->orderExtras()->pluck('extra_id')->toArray();

        return Extra::orderBy('name')
            ->active()
            ->whereNotIn('id', $_ids)
            ->whereHas('service', function ($query) use($order) {
                $ids = $order->orderServices()->pluck('service_id')->toArray();
                $query->whereIn('service_id', $ids);
            })
            ->get()
            ->map(fn(Extra $extra) => [
                'id' => $extra->id,
                'name' => $extra->name,
                'price' => $extra->price,
            ])
            ->toArray();
    }

    public function OrderToPay()
    {
        return Order::orderByDesc('created_at')->whereHas('status', function ($query) {
            $query->where('value', OrderStatus::AWAITING)->orWhere('value', OrderStatus::PREPAID);
        })->getModels();
    }
}
