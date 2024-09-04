<?php

use App\Modules\Calendar\Entity\Rule;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Modules\Calendar\Entity\Calendar;

Breadcrumbs::for('admin.calendar.calendar.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Calendar', route('admin.calendar.calendar.index'));
});
Breadcrumbs::for('admin.calendar.calendar.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.calendar.calendar.index');
    $trail->push('Добавить Calendar', route('admin.calendar.calendar.create'));
});

Breadcrumbs::for('admin.calendar.calendar.show', function (BreadcrumbTrail $trail, Calendar $calendar) {
    $trail->parent('admin.calendar.calendar.index');
    $trail->push($calendar->id, route('admin.calendar.calendar.show', $calendar));
});

Breadcrumbs::for('admin.calendar.calendar.edit', function (BreadcrumbTrail $trail, Calendar $calendar) {
    $trail->parent('admin.calendar.calendar.show', $calendar);
    $trail->push('Редактировать', route('admin.calendar.calendar.edit', $calendar));
});

Breadcrumbs::for('admin.calendar.rule.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Правила', route('admin.calendar.rule.index'));
});
Breadcrumbs::for('admin.calendar.rule.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.calendar.rule.index');
    $trail->push('Добавить Правило', route('admin.calendar.rule.create'));
});

Breadcrumbs::for('admin.calendar.rule.show', function (BreadcrumbTrail $trail, Rule $rule) {
    $trail->parent('admin.calendar.rule.index');
    $trail->push($rule->name, route('admin.calendar.rule.show', $rule));
});

Breadcrumbs::for('admin.calendar.rule.edit', function (BreadcrumbTrail $trail, Rule $rule) {
    $trail->parent('admin.calendar.rule.show', $rule);
    $trail->push('Редактировать', route('admin.calendar.rule.edit', $rule));
});
