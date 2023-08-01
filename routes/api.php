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

Route::group(['middleware' => 'api.token.verify'], function () {
    Route::get('/check', function () {
        return 'success';
    });
    Route::controller(RotatorApiController::class)->group(function () {
        Route::get('/rotator-list', 'getRotator');
        Route::get('/rotator-detail/{id}', 'getIdRotator');
        Route::get('/rotator-click-detail/{id}', 'getClickID');
    });
    Route::controller(RotatorAnaliticApiController::class)->group(function () {
        Route::get('/router-click-line/{id}', 'getLineClickID');
        Route::get('/router-all-click-line', 'getLineClick');
    });
});
