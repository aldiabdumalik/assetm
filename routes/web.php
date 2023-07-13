<?php

use App\Http\Controllers\ArrivalItemController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\RegionalController as MasterRegional;
use App\Http\Controllers\Master\UserController as MasterUser;
use App\Http\Controllers\Master\ModelController as MasterItem;
use App\Http\Controllers\ScanningController;
use App\Http\Controllers\TestingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('login', 'index')->name('login');
    });
    Route::post('auth', 'auth')->name('auth');
    Route::get('logout', 'logout')->name('logout');
});
Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.index');
        Route::get('dashboard', 'index')->name('dashboard');
    });
    Route::controller(ArrivalItemController::class)->group(function () {
        Route::get('/arrival_item', 'index')->name('arrival');
        Route::get('/arrival_item_data', 'itemData')->name('arrival.detail');
        Route::post('/arrival_item_data', 'itemDataDt')->name('arrival.data');
        Route::post('/arrival_item/datatable', 'itemDataDt')->name('arrival.datatable');
        Route::post('/arrival_item', 'addItem')->name('arrival.add');
        Route::put('/arrival_item/{id}/edit', 'editItem')->name('arrival.edit');
    });
    Route::controller(ScanningController::class)->group(function () {
        // Route::get('/scanning', 'index')->name('scanning');
        Route::get('/scanning/{id}/item', 'index')->name('scanning');
        Route::post('/scanning/datatable', 'scanDt')->name('scanning.datatable');
        Route::post('/scanning/{id}/add', 'scanItem')->name('scanning.add');
        Route::delete('/scanning/{id}/cancel', 'scanItemCancel')->name('scanning.cancel');
    });
    Route::controller(TestingController::class)->group(function () {
        Route::get('/uji_fungsi', 'index')->name('testing');
        Route::get('/uji_fungsi/scan', 'scan')->name('testing.scan');
        Route::post('/uji_fungsi/scan', 'scanItem')->name('testing.scanItem');
        Route::post('/uji_fungsi/scan/datatable', 'testingDt')->name('testing.scan.datatable');
        Route::get('/uji_fungsi/datatable', 'testingDtGroup')->name('testing.scan.datatable.grouping');
        Route::delete('/uji_fungsi/{id}/cancel', 'scanCancel')->name('testing.cancel');
        Route::get('/uji_fungsi/update', 'updateStatus')->name('testing.update');
    });
});
Route::middleware(['auth'])->group(function () {
    Route::controller(MasterRegional::class)->group(function () {
        Route::get('/regional', 'index')->name('regional');
        Route::post('/regional/datatable', 'regionalDt')->name('regional.datatable');
        Route::post('/regional/add', 'regionalAdd')->name('regional.add');
        Route::put('/regional/{id}/edit', 'regionalEdit')->name('regional.edit');
        Route::get('/regional/detail', 'reqDetail')->name('regional.detail');
        Route::post('/regional/add/wilayah', 'branchAdd')->name('regional.add.wilayah');
        Route::put('/regional/{id}/edit/wilayah', 'branchEdit')->name('regional.edit.wilayah');
    });
    Route::controller(MasterUser::class)->group(function () {
        Route::get('/user', 'index')->name('user');
        Route::post('/user/datatable', 'userDt')->name('user.datatable');
        Route::post('/user/add', 'userAdd')->name('user.add');
        Route::put('/user/{id}/edit', 'userEdit')->name('user.edit');
        Route::put('/user/{id}/set_password', 'userSetPassword')->name('user.setpassword');
        Route::delete('/user/{id}/delete', 'userDelete')->name('user.delete');
        Route::get('/user/detail', 'userDetail')->name('user.detail');
    });
    Route::controller(MasterItem::class)->group(function () {
        Route::get('/item', 'index')->name('item');
        Route::post('/item/datatable', 'itemDt')->name('item.datatable');
        Route::get('/item/detail', 'itemDetail')->name('item.detail');
        Route::post('/item/add/model', 'modelAdd')->name('item.add.model');
        Route::post('/item/add/brand', 'brandAdd')->name('item.add.brand');
        Route::post('/item/add/type', 'typeAdd')->name('item.add.type');
        Route::put('/item/{id}/edit/model', 'modelEdit')->name('item.edit.model');
        Route::put('/item/{id}/edit/brand', 'brandEdit')->name('item.edit.brand');
        Route::put('/item/{id}/edit/type', 'typeEdit')->name('item.edit.type');
        Route::delete('/item/{id}/delete/model', 'modelDelete')->name('item.delete.model');
        Route::delete('/item/{id}/delete/brand', 'brandDelete')->name('item.delete.brand');
        Route::delete('/item/{id}/delete/type', 'typeDelete')->name('item.delete.type');
    });
});