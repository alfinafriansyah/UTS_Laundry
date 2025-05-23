<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\StaffHistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffWelcomeController;
use App\Http\Controllers\StaffPelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StaffTransaksiController;

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

Route::group(['prefix' => 'admin/paket'], function () {
    Route::get('/', [PaketController::class, 'index']);
    Route::post('/list', [PaketController::class, 'list']);
    // Ajax Create
    Route::get('/create', [PaketController::class, 'create']);
    Route::post('/store', [PaketController::class, 'store']);
    // Ajax Update
    Route::get('/{id}/edit', [PaketController::class, 'edit']);
    Route::put('/{id}/update', [PaketController::class, 'update']);
    // Ajax Delete
    Route::get('/{id}/delete', [PaketController::class, 'confirm']);
    Route::delete('/{id}/delete', [PaketController::class, 'delete']);
});

Route::group(['prefix' => 'admin/transaksi'], function () {
    Route::get('/', [TransaksiController::class, 'index']);
    Route::post('/store', [TransaksiController::class, 'store']);
});

Route::group(['prefix' => 'admin/history'], function () {
    Route::get('/', [HistoryController::class, 'index']);
    Route::post('/list', [HistoryController::class, 'list']);
    Route::post('update-status', [HistoryController::class, 'updateStatus']);
    Route::delete('delete/{id}', [HistoryController::class, 'destroy']);
});

Route::get('staff/', [StaffWelcomeController::class,'index']);

Route::group(['prefix' => 'staff/pelanggan'], function () {
    Route::get('/', [StaffPelangganController::class, 'index']);
    Route::post('/list', [StaffPelangganController::class, 'list']);
    // Ajax Create
    Route::get('/create', [StaffPelangganController::class, 'create']);
    Route::post('/store', [StaffPelangganController::class, 'store']);
    // Ajax Update
    Route::get('/{id}/edit', [StaffPelangganController::class, 'edit']);
    Route::put('/{id}/update', [StaffPelangganController::class, 'update']);
    // Ajax Delete
    Route::get('/{id}/delete', [StaffPelangganController::class, 'confirm']);
    Route::delete('/{id}/delete', [StaffPelangganController::class, 'delete']);
});

Route::group(['prefix' => 'staff/transaksi'], function () {
    Route::get('/', [StaffTransaksiController::class, 'index']);
    Route::post('/store', [StaffTransaksiController::class, 'store']);
});

Route::group(['prefix' => 'staff/history'], function () {
    Route::get('/', [StaffHistoryController::class, 'index']);
    Route::post('/list', [StaffHistoryController::class, 'list']);
    Route::post('update-status', [StaffHistoryController::class, 'updateStatus']);
    Route::delete('delete/{id}', [StaffHistoryController::class, 'destroy']);
});