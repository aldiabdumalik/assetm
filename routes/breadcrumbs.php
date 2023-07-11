<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});
Breadcrumbs::for('arrival', function (BreadcrumbTrail $trail) {
    $trail->push('AMS Incoming Good Inspection', route('arrival'));
});