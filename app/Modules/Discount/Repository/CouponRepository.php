<?php

namespace App\Modules\Discount\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Discount\Entity\Coupon;

class CouponRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Coupon::orderByDesc('created_at');
        /**
         * Фильтр, для каждого параметра своя проверка
         */
        $filters = [];
        if ($request->has('status')) {
            $status = $request->integer('status');
            $filters['status'] = $status;
            $query->where('status', $status);
        }

        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Coupon $coupon) => $this->CouponToArray($coupon));
    }


    public function CouponToArray(Coupon $coupon): array
    {
        return [
            'id' => $coupon->id,
            'created_at' => $coupon->created_at->translatedFormat('j F Y'),
            'status' => $coupon->statusText(),
            'user' => $coupon->user->fullname->getFullName(),
            'bonus' => price($coupon->bonus),
            'min' => price($coupon->min),
            'finished_at' => is_null($coupon->finished_at) ? 'бессрочно' : $coupon->finished_at->translatedFormat('j F Y'),
//            'destroy' => route('admin.discount.coupon.destroy', $coupon),

        ];
    }
}
