<?php

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

Breadcrumbs::for('admin.discount.promotion.show', function (BreadcrumbTrail $trail, Promotion $discount) {
    $trail->parent('admin.discount.promotion.index');
    $trail->push($discount->name, route('admin.discount.promotion.show', $discount));
});

Breadcrumbs::for('admin.discount.promotion.edit', function (BreadcrumbTrail $trail, Promotion $discount) {
    $trail->parent('admin.discount.promotion.show', $discount);
    $trail->push('Редактировать', route('admin.discount.promotion.edit', $discount));
});


