<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


//TODO Собрать все Breadcrumbs из Moduls

Breadcrumbs::for('admin.home', function (BreadcrumbTrail $trail) {
    $trail->push('SDS', route('admin.home'));
});

Breadcrumbs::for('admin.staff.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Сотрудники', route('admin.staff.index'));
});
