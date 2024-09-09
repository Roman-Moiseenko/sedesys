<?php

use App\Modules\Discount\Entity\Coupon;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Modules\Discount\Entity\Promotion;

Breadcrumbs::for('admin.discount.promotion.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Акции', route('admin.discount.promotion.index'));
});
Breadcrumbs::for('admin.discount.promotion.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.discount.promotion.index');
    $trail->push('Добавить акцию', route('admin.discount.promotion.create'));
});

Breadcrumbs::for('admin.discount.promotion.show', function (BreadcrumbTrail $trail, Promotion $promotion) {
    $trail->parent('admin.discount.promotion.index');
    $trail->push($promotion->name, route('admin.discount.promotion.show', $promotion));
});

Breadcrumbs::for('admin.discount.promotion.edit', function (BreadcrumbTrail $trail, Promotion $promotion) {
    $trail->parent('admin.discount.promotion.show', $promotion);
    $trail->push('Редактировать', route('admin.discount.promotion.edit', $promotion));
});


Breadcrumbs::for('admin.discount.coupon.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Купоны', route('admin.discount.coupon.index'));
});
Breadcrumbs::for('admin.discount.coupon.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.discount.coupon.index');
    $trail->push('Создать купон(ы)', route('admin.discount.coupon.create'));
});

Breadcrumbs::for('admin.discount.coupon.show', function (BreadcrumbTrail $trail, Coupon $coupon) {
    $trail->parent('admin.discount.coupon.index');
    $trail->push($coupon->name, route('admin.discount.coupon.show', $coupon));
});

Breadcrumbs::for('admin.discount.coupon.edit', function (BreadcrumbTrail $trail, Coupon $coupon) {
    $trail->parent('admin.discount.coupon.show', $coupon);
    $trail->push('Редактировать', route('admin.discount.coupon.edit', $coupon));
});
