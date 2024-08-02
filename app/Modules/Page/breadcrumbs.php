<?php

use App\Modules\Page\Entity\Contact;
use App\Modules\Page\Entity\Gallery;
use App\Modules\Page\Entity\Page;
use App\Modules\Page\Entity\Widget;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

//PAGE
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

//WIDGET
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

//CONTACT
Breadcrumbs::for('admin.page.contact.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Контакты', route('admin.page.contact.index'));
});
Breadcrumbs::for('admin.page.contact.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.page.contact.index');
    $trail->push('Добавить контакт', route('admin.page.contact.create'));
});
Breadcrumbs::for('admin.page.contact.show', function (BreadcrumbTrail $trail, Contact $contact) {
    $trail->parent('admin.page.contact.index');
    $trail->push($contact->name, route('admin.page.contact.show', $contact));
});
Breadcrumbs::for('admin.page.contact.edit', function (BreadcrumbTrail $trail, Contact $contact) {
    $trail->parent('admin.page.contact.show', $contact);
    $trail->push('Редактировать', route('admin.page.contact.edit', $contact));
});

//GALLERY
Breadcrumbs::for('admin.page.gallery.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Галерея', route('admin.page.gallery.index'));
});
Breadcrumbs::for('admin.page.gallery.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.page.gallery.index');
    $trail->push('Добавить раздел', route('admin.page.gallery.create'));
});
Breadcrumbs::for('admin.page.gallery.show', function (BreadcrumbTrail $trail, Gallery $gallery) {
    $trail->parent('admin.page.gallery.index');
    $trail->push($gallery->name, route('admin.page.gallery.show', $gallery));
});
Breadcrumbs::for('admin.page.gallery.edit', function (BreadcrumbTrail $trail, Gallery $gallery) {
    $trail->parent('admin.page.gallery.show', $gallery);
    $trail->push('Редактировать', route('admin.page.gallery.edit', $gallery));
});

/*
 *
Breadcrumbs::for('/', function (BreadcrumbTrail $trail) {
    $trail->push('home', route('/'));
});

*/
