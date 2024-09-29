<?php

namespace App\Modules\Order\Service;

use App\Modules\Admin\Entity\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Order\Entity\OrderPayment;
use Illuminate\Support\Facades\Auth;

class OrderPaymentService
{

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(Request $request): OrderPayment
    {
        /** @var Admin $staff */
        $staff = Auth::guard('admin')->user();
        $payment = OrderPayment::register(
            $request->integer('order_id'),
            $request->integer('amount'),
            $request->integer('method'),
        );

        $payment->staff_id = $staff->id;
        $payment->document = $request->string('document')->trim()->value();
        $payment->save();

        $payment->order->addHistory(
            action: 'Поступила оплата',
            object: $this->objectText($payment),
            value: $payment->amount,
            url: route('admin.order.payment.show', $payment)
        );

        $this->orderService->check_payment($payment->order);
        return  $payment;
    }


    private function objectText(OrderPayment $payment): string
    {
        return '№ ' . $payment->id .
            ' от ' . $payment->htmlDate() .
            (!empty($payment->document) ? ' (' . $payment->document . ')' : '');
    }

    public function update(OrderPayment $orderPayment, Request $request)
    {
        //TODO Сохранять в логах????
        $orderPayment->method = $request->integer('method');
        $orderPayment->document = $request->string('document')->trim()->value();
        $orderPayment->save();
    }


    public function destroy(OrderPayment $payment)
    {
        $payment->order->addHistory(
            action: 'Удален платеж',
            object: $this->objectText($payment),
            value: $payment->amount,
        );
        $payment->delete();
        $this->orderService->check_payment($payment->order);
    }
}
