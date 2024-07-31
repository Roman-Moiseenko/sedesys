<?php
declare(strict_types=1);


use App\Modules\Employee\Entity\Employee;
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

Breadcrumbs::for('web.employee.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.home');
    $trail->push('Специалисты', route('web.employee.index'));
});

Breadcrumbs::for('web.employee.view', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->parent('web.employee.index');
    $trail->push($employee->fullname->getShortname(), route('web.employee.view', $employee));
});
