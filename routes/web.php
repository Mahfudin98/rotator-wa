<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\RotatorController;
use App\Http\Controllers\UserSystemInfoController;
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

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/rotator', [RotatorController::class, 'index'])->name('rotator.list');
Route::get('/add-single-rotator', [RotatorController::class, 'create'])->name('single');
Route::post('/single-rotator', [RotatorController::class, 'postSingle'])->name('post.single');

Route::get('/add-rotator', function () {
    return view('rotatoradd');
})->name('rotator');

Route::get('/test', function () {
    return view('test');
})->name('test');

Route::get('/cs/{link}', [RotatorController::class, 'showUrl'])->name('link');
Route::get('/rotator/view/{id}', [RotatorController::class, 'showRotator'])->name('show.rotator');
Route::post('/add-rotator', [RotatorController::class, 'postRotator'])->name('post.rotator');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/userinfo', [UserSystemInfoController::class, 'getusersysteminfo']);
