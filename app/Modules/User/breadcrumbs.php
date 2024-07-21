<?php

use App\Modules\User\Entity\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('admin.user.user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Клиенты', route('admin.user.user.index'));
});

Breadcrumbs::for('admin.user.user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.user.user.index');
    $trail->push('Добавить клиента', route('admin.user.user.create'));
});

Breadcrumbs::for('admin.user.user.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('admin.user.user.index');
    $trail->push($user->fullname->getShortname(), route('admin.user.user.show', $user));
});

Breadcrumbs::for('admin.user.user.edit', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('admin.user.user.show', $user);
    $trail->push('Редактировать', route('admin.user.user.edit', $user));
});
