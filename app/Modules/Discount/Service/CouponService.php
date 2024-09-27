<?php

namespace App\Modules\Discount\Service;

use App\Modules\Discount\Events\CouponHasCreated;
use App\Modules\Setting\Entity\Discount;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\User\Entity\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Discount\Entity\Coupon;
use Illuminate\Support\Facades\DB;

class CouponService
{

    private Discount $discount;

    public function __construct(SettingRepository $settings)
    {
        $this->discount = $settings->getDiscount();

    }

    public function create(Request $request): int
    {
        $finish_at = $request->input('finish_at');
        $min = $request->integer('min');
        $bonus = $request->integer('bonus');
        $count = 0;

        $query = User::where('status', User::STATUS_ACTIVE);

        if (!$request->boolean('condition.all')) {
            $users_id = $request->input('users', []);
            //TODO Условия, доделать когда будет модуль Order
            if ($request->input('condition.long_days') !== null) {
                //Ищем по заказам которые исполнены более long_days дней,
                $_ids = [];
                $users_id = array_merge($users_id, $_ids);
            }
            if ($request->input('condition.payment_before') !== null) {
                //Ищем по заказам сумму по клиентам, которая меньше payment_before,
                $_ids = [];
                $users_id = array_merge($users_id, $_ids);
            }
            if ($request->input('condition.payment_after') !== null) {
                //Ищем по заказам сумму по клиентам, которая больше payment_after,
                $_ids = [];
                $users_id = array_merge($users_id, $_ids);
            }
            $query->whereIn('id', $users_id);

        }
        $users = $query->getModels();


        foreach ($users as $user) {
            DB::transaction(function () use ($user, $finish_at, $min, &$count, $bonus) {
                $count++;
                $code = $this->generate($this->discount->coupon_length, $this->discount->coupon_full);
                $coupon = Coupon::register($user->id, $bonus, $code, $finish_at, $min);
                event(new CouponHasCreated($coupon));
            });
        }
        return $count;
    }

    public function destroy(Coupon $coupon)
    {
        if ($coupon->isNew()) {
            $coupon->delete();
        } else {
            throw new \DomainException('Купон сменил статус, удалить нельзя');
        }
    }

    public function generate(int $length = 6, bool $full = false): string
    {
        $a = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $b = 'abcdefghijklmnopqrstuvwxyz';
        $a_length = 36;
        $b_length = 26;
        $code = '';
        if ($full) {
            $a .= $b;
            $a_length += $b_length;
        }
        do {
            for ($i = 0; $i < $length; $i++) {
                $code .= $a[rand(0, ($a_length - 1))];
            }
            $coupon = Coupon::where('code', $code);
        } while (is_null($coupon));

        return $code;
    }
}
