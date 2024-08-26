<?php
declare(strict_types=1);


use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Service\Entity\Classification;
use App\Modules\Web\Repository\WebRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('web.home', function (BreadcrumbTrail $trail) {
    $trail->push('<i class="fa-light fa-house"></i>', route('web.home'));
});



Breadcrumbs::for('web.page.view', function (BreadcrumbTrail $trail, $slug) {
    $page = (new WebRepository())->PageBySlug($slug);
    $trail->parent('web.home');
    $trail->push($page->name, route('web.page.view', $slug));
});



//????? =>

// <= ?????
//УСЛУГИ
///БЕЗ КЛАССИФИКАЦИИ
/*
Breadcrumbs::for('web.service.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.home');
    $trail->push('Услуги', route('web.service.index'));
});
Breadcrumbs::for('web.service.view', function (BreadcrumbTrail $trail, $slug) {
    $service = \App\Modules\Service\Entity\Service::where('slug', $slug)->first();
    $trail->parent('web.service.index'); //$trail->parent('web.specialization.index');
    $trail->push($service->name, route('web.service.view', $slug));
});
*/
///С КЛАССИФИКАЦИЕЙ
Breadcrumbs::for('web.classification.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.home'); //$trail->parent('web.specialization.index');
    $trail->push('Услуги', route('web.classification.index'));
});
Breadcrumbs::for('web.classification.view', function (BreadcrumbTrail $trail, $slug) {
    $classification = Classification::where('slug', $slug)->first();
    $trail->parent('web.classification.index'); //$trail->parent('web.specialization.index');
    $trail->push($classification->name, route('web.classification.view', $slug));
});

//СПЕЦИАЛИСТЫ
///СО СПЕЦИАЛИЗАЦИЕЙ
Breadcrumbs::for('web.specialization.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.home'); //$trail->parent('web.specialization.index');
    $trail->push('Наша команда', route('web.specialization.index'));
});
Breadcrumbs::for('web.specialization.view', function (BreadcrumbTrail $trail, $slug  ) {
    $specialization = Specialization::where('slug', $slug)->first();
    $trail->parent('web.specialization.index'); //$trail->parent('web.specialization.index');
    $trail->push($specialization->name, route('web.specialization.view', $slug));
});
Breadcrumbs::for('web.employee.view', function (BreadcrumbTrail $trail, Employee $employee) {
    $specialization = $employee->specializations()->first();
    $trail->parent('web.specialization.view', $specialization->slug);
    $trail->push($employee->fullname->getShortname(), route('web.employee.view', $employee));
});


///БЕЗ СПЕЦИАЛИЗАЦИИ
/*
Breadcrumbs::for('web.employee.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.home');
    $trail->push('Специалисты', route('web.employee.index'));
});

Breadcrumbs::for('web.employee.view', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->parent('web.employee.index');
    $trail->push($employee->fullname->getShortname(), route('web.employee.view', $employee));
});
*/

Breadcrumbs::for('web.test', function (BreadcrumbTrail $trail) {
    $trail->push('<i class="fa-light fa-house"></i>', route('web.test'));
});


