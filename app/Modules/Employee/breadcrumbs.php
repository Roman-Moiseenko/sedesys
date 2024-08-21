<?php

use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('admin.employee.employee.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Персонал', route('admin.employee.employee.index'));
});
Breadcrumbs::for('admin.employee.employee.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.employee.employee.index');
    $trail->push('Добавить Персонал', route('admin.employee.employee.create'));
});

Breadcrumbs::for('admin.employee.employee.show', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->parent('admin.employee.employee.index');
    $trail->push($employee->fullname->getShortname(), route('admin.employee.employee.show', $employee));
});

Breadcrumbs::for('admin.employee.employee.edit', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->parent('admin.employee.employee.show', $employee);
    $trail->push('Редактировать', route('admin.employee.employee.edit', $employee));
});


Breadcrumbs::for('admin.employee.specialization.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Специализация', route('admin.employee.specialization.index'));
});
Breadcrumbs::for('admin.employee.specialization.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.employee.employee.index');
    $trail->push('Добавить Специализацию', route('admin.employee.specialization.create'));
});

Breadcrumbs::for('admin.employee.specialization.show', function (BreadcrumbTrail $trail, Specialization $specialization) {
    $trail->parent('admin.employee.specialization.index');
    $trail->push($specialization->name, route('admin.employee.specialization.show', $specialization));
});

Breadcrumbs::for('admin.employee.specialization.edit', function (BreadcrumbTrail $trail, Specialization $specialization) {
    $trail->parent('admin.employee.specialization.show', $specialization);
    $trail->push('Редактировать', route('admin.employee.specialization.edit', $specialization));
});

/*
Breadcrumbs::for('admin.employee.operating.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.employee.employee.index');
    $trail->push('График работы', route('admin.employee.operating.index'));
});

Breadcrumbs::for('admin.employee.message.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.employee.employee.index');
    $trail->push('Уведомления', route('admin.employee.message.index'));
});
*/
