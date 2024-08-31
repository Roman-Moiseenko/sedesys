<?php

use App\Modules\Service\Entity\Example;
use App\Modules\Service\Entity\Review;
use App\Modules\Service\Entity\Service;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Modules\Service\Entity\Classification;

//CLASSIFICATION
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

//SERVICE
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

//EXAMPLE
Breadcrumbs::for('admin.service.example.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Примеры работ', route('admin.service.example.index'));
});
Breadcrumbs::for('admin.service.example.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.service.example.index');
    $trail->push('Добавить пример', route('admin.service.example.create'));
});

Breadcrumbs::for('admin.service.example.show', function (BreadcrumbTrail $trail, Example $example) {
    $trail->parent('admin.service.example.index');
    $trail->push($example->title, route('admin.service.example.show', $example));
});
Breadcrumbs::for('admin.service.example.edit', function (BreadcrumbTrail $trail, Example $example) {
    $trail->parent('admin.service.example.show', $example);
    $trail->push('Редактировать', route('admin.service.example.edit', $example));
});

//REVIEW
Breadcrumbs::for('admin.service.review.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Отзывы', route('admin.service.review.index'));
});
Breadcrumbs::for('admin.service.review.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.service.review.index');
    $trail->push('Добавить отзыв', route('admin.service.review.create'));
});

Breadcrumbs::for('admin.service.review.show', function (BreadcrumbTrail $trail, Review $review) {
    $trail->parent('admin.service.review.index');
    if (is_null($review->service_id)) {
        $caption = 'Отзыв на компанию';
    } else {
        $caption = 'Отзыв на услугу ' . $review->service->name;
    }
    $trail->push($caption, route('admin.service.review.show', $review));
});
Breadcrumbs::for('admin.service.review.edit', function (BreadcrumbTrail $trail, Review $review) {
    $trail->parent('admin.service.review.show', $review);
    $trail->push('Редактировать', route('admin.service.review.edit', $review));
});
