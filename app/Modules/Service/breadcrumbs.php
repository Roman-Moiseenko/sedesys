<?php

use App\Modules\Service\Entity\Service;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Modules\Service\Entity\Classification;

Breadcrumbs::for('admin.service.classification.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Классификация услуг', route('admin.service.classification.index'));
});
Breadcrumbs::for('admin.service.classification.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.service.classification.index');
    $trail->push('Добавить классификацию', route('admin.service.classification.create'));
});

Breadcrumbs::for('admin.service.classification.show', function (BreadcrumbTrail $trail, Classification $classification) {
    $trail->parent('admin.service.classification.index');
    $trail->push($classification->name, route('admin.service.classification.show', $classification));
});

Breadcrumbs::for('admin.service.classification.edit', function (BreadcrumbTrail $trail, Classification $classification) {
    $trail->parent('admin.service.classification.show', $classification);
    $trail->push('Редактировать', route('admin.service.classification.edit', $classification));
});


Breadcrumbs::for('admin.service.service.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Услуги', route('admin.service.service.index'));
});
Breadcrumbs::for('admin.service.service.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.service.service.index');
    $trail->push('Добавить услугу', route('admin.service.service.create'));
});

Breadcrumbs::for('admin.service.service.show', function (BreadcrumbTrail $trail, Service $service) {
    $trail->parent('admin.service.service.index');
    $trail->push($service->name, route('admin.service.service.show', $service));
});

Breadcrumbs::for('admin.service.service.edit', function (BreadcrumbTrail $trail, Service $service) {
    $trail->parent('admin.service.service.show', $service);
    $trail->push('Редактировать', route('admin.service.service.edit', $service));
});
