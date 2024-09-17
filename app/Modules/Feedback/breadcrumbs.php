<?php

use App\Modules\Feedback\Entity\Template;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Modules\Feedback\Entity\Feedback;


Breadcrumbs::for('admin.feedback.feedback.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Заявки от клиентов', route('admin.feedback.feedback.dashboard'));
});

Breadcrumbs::for('admin.feedback.feedback.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.feedback.feedback.dashboard');
    $trail->push('Архив', route('admin.feedback.feedback.index'));
});
/*
Breadcrumbs::for('admin.feedback.feedback.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.feedback.feedback.index');
    $trail->push('Добавить Feedback', route('admin.feedback.feedback.create'));
});
*/
Breadcrumbs::for('admin.feedback.feedback.show', function (BreadcrumbTrail $trail, Feedback $feedback) {
    $trail->parent('admin.feedback.feedback.index');
    $trail->push($feedback->template->name, route('admin.feedback.feedback.show', $feedback));
});

/*
Breadcrumbs::for('admin.feedback.feedback.edit', function (BreadcrumbTrail $trail, Feedback $feedback) {
    $trail->parent('admin.feedback.feedback.show', $feedback);
    $trail->push('Редактировать', route('admin.feedback.feedback.edit', $feedback));
});
*/

Breadcrumbs::for('admin.feedback.template.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Шаблон заявки', route('admin.feedback.template.index'));
});
Breadcrumbs::for('admin.feedback.template.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.feedback.template.index');
    $trail->push('Добавить шаблон', route('admin.feedback.template.create'));
});

Breadcrumbs::for('admin.feedback.template.show', function (BreadcrumbTrail $trail, Template $template) {
    $trail->parent('admin.feedback.template.index');
    $trail->push($template->name, route('admin.feedback.template.show', $template));
});

Breadcrumbs::for('admin.feedback.template.edit', function (BreadcrumbTrail $trail, Template $template) {
    $trail->parent('admin.feedback.template.show', $template);
    $trail->push('Редактировать', route('admin.feedback.template.edit', $template));
});
