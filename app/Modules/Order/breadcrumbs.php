<?php

use App\Modules\Order\Entity\OrderPayment;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Modules\Order\Entity\Order;

Breadcrumbs::for('admin.order.order.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Заказы', route('admin.order.order.index'));
});
Breadcrumbs::for('admin.order.order.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.order.order.index');
    $trail->push('Добавить заказ', route('admin.order.order.create'));
});

Breadcrumbs::for('admin.order.order.show', function (BreadcrumbTrail $trail, Order $order) {
    $trail->parent('admin.order.order.index');
    $trail->push($order->htmlNumDate(), route('admin.order.order.show', $order));
});

Breadcrumbs::for('admin.order.order.edit', function (BreadcrumbTrail $trail, Order $order) {
    $trail->parent('admin.order.order.show', $order);
    $trail->push('Редактировать', route('admin.order.order.edit', $order));
});

Breadcrumbs::for('admin.order.payment.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Платежи', route('admin.order.payment.index'));
});
Breadcrumbs::for('admin.order.payment.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.order.payment.index');
    $trail->push('Добавить платеж', route('admin.order.payment.create'));
});

Breadcrumbs::for('admin.order.payment.show', function (BreadcrumbTrail $trail, OrderPayment $payment) {
    $trail->parent('admin.order.payment.index');
    $trail->push($payment->htmlDate(), route('admin.order.payment.show', $payment));
});

Breadcrumbs::for('admin.order.payment.edit', function (BreadcrumbTrail $trail, OrderPayment $payment) {
    $trail->parent('admin.order.payment.show', $payment);
    $trail->push('Редактировать', route('admin.order.payment.edit', $payment));
});

