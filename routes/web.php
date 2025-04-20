<?php

use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'admin/user'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    // Ajax Create
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/store', [UserController::class, 'store']);
    // Ajax Update
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}/update', [UserController::class, 'update']);
    // Ajax Delete
    Route::get('/{id}/delete', [UserController::class, 'confirm']);
    Route::delete('/{id}/delete', [UserController::class, 'delete']);
});

Route::group(['prefix' => 'admin/pelanggan'], function () {
    Route::get('/', [PelangganController::class, 'index']);
    Route::post('/list', [PelangganController::class, 'list']);
    // Ajax Create
    Route::get('/create', [PelangganController::class, 'create']);
    Route::post('/store', [PelangganController::class, 'store']);
    // Ajax Update
    Route::get('/{id}/edit', [PelangganController::class, 'edit']);
    Route::put('/{id}/update', [PelangganController::class, 'update']);
    // Ajax Delete
    Route::get('/{id}/delete', [PelangganController::class, 'confirm']);
    Route::delete('/{id}/delete', [PelangganController::class, 'delete']);
});