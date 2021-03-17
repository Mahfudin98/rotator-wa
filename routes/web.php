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
Route::get('/add-single-rotator', [RotatorController::class, 'create'])->middleware(['auth'])->name('single');
Route::post('/single-rotator', [RotatorController::class, 'postSingle'])->middleware(['auth'])->name('post.single');

Route::get('/add-rotator', function () {
    return view('rotatoradd');
})->middleware(['auth'])->name('rotator');

Route::get('/test', function () {
    return view('test');
})->name('test');

Route::get('/cs/{link}', [RotatorController::class, 'showUrl'])->name('link');
Route::get('/rotator/view/{id}', [RotatorController::class, 'showRotator'])->name('show.rotator');
Route::post('/add-rotator', [RotatorController::class, 'postRotator'])->middleware(['auth'])->name('post.rotator');

Route::get('/dashboard', [RotatorController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
Route::get('/edit/{id}', [RotatorController::class, 'edit'])->name('edit');
Route::get('/add/{link}', [RotatorController::class, 'tambah'])->name('tambah');
Route::post('/add/rotator', [RotatorController::class, 'postTambah'])->name('post.tambah');
Route::put('/edit/{id}', [RotatorController::class, 'updateRotator'])->name('update.rotate');
Route::put('/updaterot/{id}', [RotatorController::class, 'updateRot'])->name('update.rot');
Route::delete('/delete/cs/{id}', [RotatorController::class, 'deleteCS'])->name('delete.cs');
Route::get('/guest/show/{id}', [RotatorController::class, 'guestShowRotator'])->name('guest.show');
require __DIR__.'/auth.php';

Route::get('/userinfo', [UserSystemInfoController::class, 'getusersysteminfo']);
