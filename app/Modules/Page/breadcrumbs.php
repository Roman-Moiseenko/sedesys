<?php

use App\Modules\Page\Entity\Page;
use App\Modules\Page\Entity\Widget;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('admin.page.page.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Страницы', route('admin.page.page.index'));
});
Breadcrumbs::for('admin.page.page.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.page.page.index');
    $trail->push('Добавить страницу', route('admin.page.page.create'));
});

Breadcrumbs::for('admin.page.page.show', function (BreadcrumbTrail $trail, Page $page) {
    $trail->parent('admin.page.page.index');
    $trail->push($page->name, route('admin.page.page.show', $page));
});

Breadcrumbs::for('admin.page.page.edit', function (BreadcrumbTrail $trail, Page $page) {
    $trail->parent('admin.page.page.show', $page);
    $trail->push('Редактировать', route('admin.page.page.edit', $page));
});

Breadcrumbs::for('admin.page.widget.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Виджеты', route('admin.page.widget.index'));
});
Breadcrumbs::for('admin.page.widget.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.page.widget.index');
    $trail->push('Добавить виджет', route('admin.page.widget.create'));
});

Breadcrumbs::for('admin.page.widget.show', function (BreadcrumbTrail $trail, Widget $widget) {
    $trail->parent('admin.page.widget.index');
    $trail->push($widget->name, route('admin.page.widget.show', $widget));
});

Breadcrumbs::for('admin.page.widget.edit', function (BreadcrumbTrail $trail, Widget $widget) {
    $trail->parent('admin.page.widget.show', $widget);
    $trail->push('Редактировать', route('admin.page.widget.edit', $widget));
});


/*
 *
Breadcrumbs::for('/', function (BreadcrumbTrail $trail) {
    $trail->push('home', route('/'));
});

*/
