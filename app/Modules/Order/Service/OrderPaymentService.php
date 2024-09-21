<?php

namespace App\Modules\Order\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Order\Entity\OrderPayment;

class OrderPaymentService
{

    public function create(Request $request): OrderPayment
    {
        /**
         * Создаем объект с базовыми данными
         */
        $orderPayment = OrderPayment::register(
            $request->string('name')->trim()->value(),
        );

        $this->save_fields($orderPayment, $request);

        return  $orderPayment;
    }

    public function update(OrderPayment $orderPayment, Request $request)
    {
        /**
         * Сохраняем базовые поля
         */
        $orderPayment->name = $request->string('name')->trim()->value();
        $orderPayment->save();

        $this->save_fields($orderPayment, $request);
    }

    private function save_fields(OrderPayment $orderPayment, Request $request)
    {
        /**
         * Сохраняем оставшиеся поля
         */

        $orderPayment->save();
    }


    public function destroy(OrderPayment $orderPayment)
    {
        /**
         * Проверить на возможность удаления
         */
        $orderPayment->delete();
    }
}
