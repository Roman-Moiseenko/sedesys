<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Modules\Setting\Entity\Setting;

Breadcrumbs::for('admin.setting.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Настройки', route('admin.setting.index'));
});

Breadcrumbs::for('admin.setting.organization', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.setting.index');
    $trail->push('Организация', route('admin.setting.organization'));
});

Breadcrumbs::for('admin.setting.office', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.setting.index');
    $trail->push('Офис', route('admin.setting.office'));
});

Breadcrumbs::for('admin.setting.web', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.setting.index');
    $trail->push('Верстка', route('admin.setting.web'));
});

Breadcrumbs::for('admin.setting.notification', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.setting.index');
    $trail->push('Уведомления', route('admin.setting.notification'));
});

