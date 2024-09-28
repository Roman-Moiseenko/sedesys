<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Entity\OrderPayment;
use App\Modules\Order\Requests\OrderPaymentRequest;
use App\Modules\Order\Repository\OrderPaymentRepository;
use App\Modules\Order\Service\OrderPaymentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderPaymentController extends Controller
{

    private OrderPaymentService $service;
    private OrderPaymentRepository $repository;

    public function __construct(OrderPaymentService $service, OrderPaymentRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        $orderPayments = $this->repository->getIndex($request, $filters);

        return Inertia::render('Order/OrderPayment/Index', [
                'orderPayments' => $orderPayments,
                'filters' => $filters,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Order/OrderPayment/Create', [
        ]);
    }

    public function store(OrderPaymentRequest $request)
    {
        $request->validated();
        $orderPayment = $this->service->create($request);
        return redirect()
            ->route('admin.order.payment.show', $orderPayment)
            ->with('success', 'Новый платеж добавлен');
    }

    public function show(OrderPayment $orderPayment)
    {

        return Inertia::render('Order/OrderPayment/Show', [
                'orderPayment' => $this->repository->OrderPaymentWithToArray($orderPayment),
            ]
        );
    }

    public function edit(OrderPayment $orderPayment)
    {
        $orderPayment = $this->repository->OrderPaymentToArray($orderPayment);

        return Inertia::render('Order/OrderPayment/Edit', [
            'orderPayment' => $orderPayment,
        ]);
    }

    public function update(OrderPaymentRequest $request, OrderPayment $orderPayment)
    {
        $request->validated();
        $this->service->update($orderPayment, $request);

        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.order.payment.show', $orderPayment)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(OrderPayment $orderPayment)
    {
        $this->service->destroy($orderPayment);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
