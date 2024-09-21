<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Order\Entity\Order;
use App\Modules\Order\Requests\OrderRequest;
use App\Modules\Order\Repository\OrderRepository;
use App\Modules\Order\Service\OrderService;
use App\Modules\Service\Entity\Consumable;
use App\Modules\Service\Entity\Extra;
use App\Modules\Service\Entity\Service;
use App\Modules\Service\Repository\ConsumableRepository;
use App\Modules\Service\Repository\ServiceRepository;
use App\Modules\User\Service\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{

    private OrderService $service;
    private OrderRepository $repository;
    private ServiceRepository $services;
    private ConsumableRepository $consumables;
    private UserService $userService;

    public function __construct(
        OrderService $service,
        OrderRepository $repository,
        ServiceRepository $services,
        ConsumableRepository $consumables,
        UserService $userService,
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->services = $services;
        $this->consumables = $consumables;
        $this->userService = $userService;
    }


    public function index(Request $request)
    {
        $orders = $this->repository->getIndex($request, $filters);

        return Inertia::render('Order/Order/Index', [
                'orders' => $orders,
                'filters' => $filters,
                'create' => route('admin.order.order.create-staff'),
            ]
        );
    }

    public function create_staff(): RedirectResponse
    {
        $order = $this->service->createByStaff(base: Order::BASE_OFFLINE);

        return redirect()
            ->route('admin.order.order.show', $order)
            ->with('success', 'Новый заказ');
    }

    public function store(OrderRequest $request)
    {
        $request->validated();
        $order = $this->service->create($request);
        return redirect()
            ->route('admin.order.order.show', $order)
            ->with('success', 'Заказ сохранен');
    }

    public function show(Order $order)
    {
        return Inertia::render('Order/Order/Show', [
                'order' => $this->repository->OrderWithToArray($order),
                'services' => $this->repository->ServicesOut($order),
                'consumables' => $this->repository->ConsumablesOut($order),
                'extras' => $this->repository->ExtrasOut($order),

                'add_item' => route('admin.order.order.add-item', $order),
                'del_item' => route('admin.order.order.del-item', $order),
                'set_item' => route('admin.order.order.set-item', $order),
            ]
        );
    }

    public function add_item(Request $request, Order $order)
    {
        $item = $request->string('item')->value() . 'Add';
        $message = $this->service->$item($order, $request);
        return redirect()->back()->with('success', $message);
    }

    public function set_item(Request $request, Order $order)
    {
        $item = $request->string('item')->value() . 'Set';
        $message = $this->service->$item($order, $request);
        return redirect()->back()->with('success', $message);
    }

    public function set_user(Request $request, Order $order)
    {
        $user_id = $request->input('user_id');
        if (is_null($user_id)) {
            $user = $this->userService->create($request);
            $user_id = $user->id;
        }
        $order->setUser($user_id);

        return redirect()->back()->with('success', 'Сохранено');
    }

    public function del_item(Request $request, Order $order)
    {
        $item = $request->string('item')->value() . 'Del';
        $message = $this->service->$item($order, $request);
        return redirect()->back()->with('success', $message);
    }

    public function awaiting(Order $order)
    {
        $this->service->setAwaiting($order);
        return redirect()->back()->with('success', 'Заказ ожидает оплаты');
    }

    public function cancel(Order $order)
    {
       //TODO
    }

    public function paid(Order $order)
    {
        //TODO
    }

    public function cheque(Order $order)
    {
        //TODO
    }

    public function destroy(Order $order)
    {
        $this->service->destroy($order);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
