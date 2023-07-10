<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});
Breadcrumbs::for('admin.user', function (BreadcrumbTrail $trail) {
    $trail->push('Manage Employee', route('admin.user'));
});
Breadcrumbs::for('admin.employee', function (BreadcrumbTrail $trail) {
    $trail->push('Manage Employee', route('admin.employee'));
});
Breadcrumbs::for('admin.event', function (BreadcrumbTrail $trail) {
    $trail->push('Manage Event', route('admin.event'));
});
Breadcrumbs::for('admin.picket', function (BreadcrumbTrail $trail) {
    $trail->push('Manage Picket', route('admin.picket'));
});