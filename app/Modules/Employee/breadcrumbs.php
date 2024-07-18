<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('admin.employee.employee.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Персонал', route('admin.employee.employee.index'));
});

Breadcrumbs::for('admin.employee.operating.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.employee.employee.index');
    $trail->push('График работы', route('admin.employee.operating.index'));
});

Breadcrumbs::for('admin.employee.message.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.employee.employee.index');
    $trail->push('Уведомления', route('admin.employee.message.index'));
});
