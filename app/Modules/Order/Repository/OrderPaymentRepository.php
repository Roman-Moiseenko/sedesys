<?php

namespace App\Modules\Order\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Order\Entity\OrderPayment;

class OrderPaymentRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = OrderPayment::orderBy('name');
        /**
         * Фильтр, для каждого параметра своя проверка
         */
        $filters = [];
        if ($request->has('name')) {
            $name = $request->string('name')->trim()->value();
            $filters['name'] = $name;
            $query->where('name', 'LIKE', "%$name%");
        }

        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(OrderPayment $orderPayment) => $this->OrderPaymentToArray($orderPayment));
    }


    public function OrderPaymentToArray(OrderPayment $orderPayment): array
    {
        return [
            'id' => $orderPayment->id,
            'name' => $orderPayment->name,

        ];
    }

    public function OrderPaymentWithToArray(OrderPayment $orderPayment): array
    {
        $withData = [
            /**
             * Данные из relations
             */
        ];

        return array_merge($this->OrderPaymentToArray($orderPayment), $withData);
    }
}
