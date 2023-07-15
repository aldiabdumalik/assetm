<?php

use App\Http\Controllers\ModelController;
use App\Http\Controllers\RegionalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(RegionalController::class)->group(function () {
    Route::get('/get-regional.json', 'getRegional')->name('api.regional');
    Route::get('/get-branch.json', 'getBranch')->name('api.branch');
    Route::get('/get-branch-type.json', 'getBranchType')->name('api.branch.type');
});
Route::controller(ModelController::class)->group(function () {
    Route::get('/get-jenis.json', 'getJenis')->name('api.jenis');
    Route::get('/get-merk.json', 'getMerk')->name('api.merk');
    Route::get('/get-tipe.json', 'getTipe')->name('api.tipe');
});