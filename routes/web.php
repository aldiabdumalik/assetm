<?php

use App\Http\Controllers\ArrivalItemController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
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
        Route::delete('/uji_fungsi/{id}/cancel', 'scanCancel')->name('testing.cancel');
        Route::get('/uji_fungsi/update', 'updateStatus')->name('testing.update');
    });
});
