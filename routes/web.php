<?php

use App\Http\Controllers\ArrivalItemController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
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
        Route::get('/', 'index')->name('dashboard');
        Route::get('dashboard', 'index')->name('dashboard');
    });
    Route::controller(ArrivalItemController::class)->group(function () {
        Route::get('/arrival_item', 'index')->name('arrival');
        Route::get('/arrival_item_data', 'itemData')->name('arrival.detail');
        Route::post('/arrival_item_data', 'itemDataDt')->name('arrival.data');
        Route::post('/arrival_item/datatable', 'itemDataDt')->name('arrival.data');
        Route::post('/arrival_item', 'addItem')->name('arrival.add');
        Route::put('/arrival_item/{id}/edit', 'editItem')->name('arrival.edit');
    });
});
