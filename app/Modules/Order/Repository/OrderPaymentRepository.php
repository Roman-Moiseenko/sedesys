<?php

namespace App\Modules\Order\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Order\Entity\OrderPayment;

class OrderPaymentRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = OrderPayment::orderByDesc('created_at');
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
        if ($request->has('order')) {
            $order = $request->integer('order');
            $filters['order'] = $order;
            $query->where('order_id', $order);
        }

        if ($request->has('method')) {
            $method = $request->integer('method');
            $filters['method'] = $method;
            $query->where('method', $method);
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
            ->through(fn(OrderPayment $orderPayment) => $this->OrderPaymentToArray($orderPayment));
    }


    public function OrderPaymentToArray(OrderPayment $payment): array
    {
        return [
            'id' => $payment->id,
            'created_at' => $payment->htmlDate(),
            'order_id' => $payment->order_id,
            'order' => $payment->order->htmlNumDate(),
            'is_edit' => $payment->order->isPrepaid(),
            'user' => $payment->order->user,
            'amount' => $payment->amount,
            'method' =>  $payment->method,
            'method_text' => OrderPayment::METHODS[$payment->method],
            'document' => $payment->document,
        ];
    }

    public function OrderPaymentWithToArray(OrderPayment $orderPayment): array
    {
        $withData = [
        ];

        return array_merge($this->OrderPaymentToArray($orderPayment), $withData);
    }

    public function getMethods(): array
    {
        return array_select(OrderPayment::METHODS);
    }
}
