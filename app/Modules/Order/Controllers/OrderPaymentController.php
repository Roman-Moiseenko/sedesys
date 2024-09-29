<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Entity\Order;
use App\Modules\Order\Entity\OrderPayment;
use App\Modules\Order\Entity\OrderStatus;
use App\Modules\Order\Repository\OrderRepository;
use App\Modules\Order\Requests\OrderPaymentRequest;
use App\Modules\Order\Repository\OrderPaymentRepository;
use App\Modules\Order\Service\OrderPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderPaymentController extends Controller
{

    private OrderPaymentService $service;
    private OrderPaymentRepository $repository;
    private OrderRepository $orders;

    public function __construct(
        OrderPaymentService $service,
        OrderPaymentRepository $repository,
        OrderRepository $orders,
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->orders = $orders;
    }


    public function index(Request $request)
    {
        $orderPayments = $this->repository->getIndex($request, $filters);
        $methods = $this->repository->getMethods();

        return Inertia::render('Order/OrderPayment/Index', [
                'orderPayments' => $orderPayments,
                'filters' => $filters,
                'methods' => $methods,
            ]
        );
    }

    public function create(Request $request)
    {
        $orders = $this->orders->OrderToPay();
        $methods = $this->repository->getMethods();
        return Inertia::render('Order/OrderPayment/Create', [
            'orders' => $orders,
            'methods' => $methods,
        ]);
    }

    public function store(OrderPaymentRequest $request)
    {
        $request->validated();
        $payment = $this->service->create($request);
        return redirect()
            ->route('admin.order.payment.index')
            ->with('success', 'Новый платеж добавлен');
    }

    public function show(OrderPayment $payment)
    {
        return Inertia::render('Order/OrderPayment/Show', [
                'orderPayment' => $this->repository->OrderPaymentWithToArray($payment),
            ]
        );
    }

    public function edit(OrderPayment $payment)
    {
        $methods = $this->repository->getMethods();
        return Inertia::render('Order/OrderPayment/Edit', [
            'orderPayment' => $this->repository->OrderPaymentToArray($payment),
            'methods' => $methods,
        ]);
    }

    public function update(OrderPaymentRequest $request, OrderPayment $payment): RedirectResponse
    {
        $request->validated();
        $this->service->update($payment, $request);

        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.order.payment.index')
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(OrderPayment $payment): RedirectResponse
    {
        $this->service->destroy($payment);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
