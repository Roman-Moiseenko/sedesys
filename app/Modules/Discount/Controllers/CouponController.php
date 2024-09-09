<?php

namespace App\Modules\Discount\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Discount\Entity\Coupon;
use App\Modules\Discount\Requests\CouponRequest;
use App\Modules\Discount\Repository\CouponRepository;
use App\Modules\Discount\Service\CouponService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CouponController extends Controller
{

    private CouponService $service;
    private CouponRepository $repository;

    public function __construct(CouponService $service, CouponRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        $coupons = $this->repository->getIndex($request, $filters);

        return Inertia::render('Discount/Coupon/Index', [
                'coupons' => $coupons,
                'filters' => $filters,
                'statuses' => array_select(Coupon::STATUSES),

            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Discount/Coupon/Create', [
            'route' => route('admin.discount.coupon.store'),
            'find_phone' => route('admin.user.find_phone')
        ]);
    }

    public function store(CouponRequest $request)
    {
        $request->validated();

        $count = $this->service->create($request);
        return redirect()
            ->route('admin.discount.coupon.index')
            ->with('success', 'Создано ' . $count . ' купонов');
    }

    public function show(Coupon $coupon)
    {
        return Inertia::render('Discount/Coupon/Show', [
                'coupon' => $coupon,
                'edit' => route('admin.discount.coupon.edit', $coupon),
            ]
        );
    }

    public function destroy(Coupon $coupon): \Illuminate\Http\RedirectResponse
    {
        $this->service->destroy($coupon);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
