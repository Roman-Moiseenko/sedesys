<?php
declare(strict_types=1);


use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Web\Repository\WebRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('web.home', function (BreadcrumbTrail $trail) {
    $trail->push('<i class="fa-light fa-house"></i>', route('web.home'));
});

Breadcrumbs::for('web.services', function (BreadcrumbTrail $trail) {
    $trail->parent('web.home');
    $trail->push('Услуги', route('web.services'));
});


Breadcrumbs::for('web.page.view', function (BreadcrumbTrail $trail, $slug) {
    $page = (new WebRepository())->PageBySlug($slug);
    $trail->parent('web.home');
    $trail->push($page->name, route('web.page.view', $slug));
});

Breadcrumbs::for('web.employee.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.home');
    $trail->push('Специалисты', route('web.employee.index'));
});

Breadcrumbs::for('web.employee.view', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->parent('web.employee.index');
    $trail->push($employee->fullname->getShortname(), route('web.employee.view', $employee));
});

//????? =>
Breadcrumbs::for('web.specialization.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.home');
    $trail->push('Специалисты', route('web.specialization.index'));
});
// <= ?????

Breadcrumbs::for('web.classification.view', function (BreadcrumbTrail $trail, $slug) {
    $trail->parent('web.employee.index'); //$trail->parent('web.specialization.index');
    $trail->push($slug, route('web.classification.view', $slug));
});

Breadcrumbs::for('web.specialization.view', function (BreadcrumbTrail $trail, Specialization $specialization) {
    $trail->parent('web.services'); //$trail->parent('web.specialization.index');
    $trail->push($specialization->name, route('web.specialization.view', $specialization));
});

Breadcrumbs::for('web.test', function (BreadcrumbTrail $trail) {
    $trail->push('<i class="fa-light fa-house"></i>', route('web.test'));
});


