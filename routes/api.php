<?php

use App\Http\Controllers\Api\RotatorAnaliticApiController;
use App\Http\Controllers\Api\RotatorApiController;
use App\Http\Controllers\IndexController;
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

Route::get('city', [IndexController::class, 'getCity']);
Route::get('district', [IndexController::class, 'getDistrict']);
Route::post('cost', [IndexController::class, 'getCourier']);


Route::controller(RotatorApiController::class)->group(function () {
    Route::get('/rotator-click/{url}', 'rotatorClick');
    Route::group(['middleware' => 'new.api.token.verify'], function () {
        Route::get('/rotator-list', 'getRotator');
        Route::get('/rotator-detail/{link}', 'getIdRotator');
        Route::get('/rotator-detail-list/{link}', 'getIDRotatorList');
        Route::get('/rotator-click-detail/{link}', 'getClickID');
        Route::get('/rotator-list-website', 'getWebsite');
        Route::post('/rotator-add-website', 'addWebsite');
        Route::post('/rotator-add-multi-rotator', 'addMultiRotator');
        Route::post('/rotator-add-single-rotator', 'addSingleRotator');
        Route::post('/rotator-update-link-rotator/{id}', 'updateRotator');
        Route::post('/rotator-update-pesan/{id}', 'updatePesan');
        Route::post('/rotator-add-rotator/{id}', 'addRotator');
        Route::post('/rotator-update-rotator/{id}', 'editRotator');
        Route::delete('/rotator-remove-rotator/{id}', 'nonAktifRotator');
    });
});
Route::controller(RotatorAnaliticApiController::class)->group(function () {
    Route::group(['middleware' => 'new.api.token.verify'], function () {
        Route::get('/router-click-line/{link}', 'getLineClickID');
        Route::get('/router-all-click-line', 'getLineClick');
    });
});
