<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});
Breadcrumbs::for('dashboard.index', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});
Breadcrumbs::for('arrival', function (BreadcrumbTrail $trail) {
    $trail->push('AMS Incoming Good Inspection', route('arrival'));
});
Breadcrumbs::for('scanning', function (BreadcrumbTrail $trail) {
    $trail->push('Actual Scanning', '#');
});

Breadcrumbs::for('testing', function (BreadcrumbTrail $trail) {
    $trail->push('AMS Uji Fungsi', '#');
});
Breadcrumbs::for('testing.scan', function (BreadcrumbTrail $trail) {
    $trail->push('Actual Scanning', '#');
});
Breadcrumbs::for('testing.detail', function (BreadcrumbTrail $trail) {
    $trail->push('Result Scanning', '#');
});

Breadcrumbs::for('regional', function (BreadcrumbTrail $trail) {
    $trail->push('Regional', route('regional'));
});
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push('User', route('user'));
});
Breadcrumbs::for('item', function (BreadcrumbTrail $trail) {
    $trail->push('Item', route('item'));
});

Breadcrumbs::for('packing', function (BreadcrumbTrail $trail) {
    $trail->push('Packing List', route('packing'));
});