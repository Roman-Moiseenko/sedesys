<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


modules_callback('breadcrumbs.php', function ($routesPath) {
    require $routesPath;
});
