<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\OutcomingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->middleware('auth');

// ============================== USER ==============================

Route::get('/user', [UserController::class, 'index'])->middleware('auth');

Route::post('/user', [UserController::class, 'store'])->middleware('auth');

// ============================== INVENTORY ==============================

Route::get('/inventory/bahanbaku', [InventoryController::class, 'bahanBaku'])->middleware('auth');

Route::get('/inventory/kemasan', [InventoryController::class, 'kemasan'])->middleware('auth');

Route::get('/inventory/produkjadi', [InventoryController::class, 'produkJadi'])->middleware('auth');

Route::get('/inventory/type/{jenis}', [InventoryController::class, 'index'])->middleware('auth');

// ============================== SHOP ==============================

Route::get('/shop', [ShopController::class, 'index'])->middleware('auth');

Route::post('/shop', [ShopController::class, 'store'])->middleware('auth');

// ============================== INCOMING ==============================

Route::get('/incoming', [IncomingController::class, 'index'])->middleware('auth');

Route::get('/incoming', [IncomingController::class, 'create'])->middleware('auth');

Route::post('/incoming', [IncomingController::class, 'store'])->middleware('auth');

Route::get('/get-barang/{jenis}', [IncomingController::class, 'getBarang']);

// ============================== OUTCOMING ==============================

Route::get('/outcoming', [OutcomingController::class, 'index'])->middleware('auth');

Route::get('/outcoming', [OutcomingController::class, 'create'])->middleware('auth');

Route::post('/outcoming', [OutcomingController::class, 'store'])->middleware('auth');

Route::get('/get-barang/{jenis}', [OutcomingController::class, 'getBarang']);

// ============================== TRANSACTION ==============================

Route::get('/transaction', [TransactionController::class, 'index'])->middleware('auth');

// ============================== EDIT ==============================

Route::get('/inventory/edit/{id}', [InventoryController::class, 'edit'])->middleware('auth');

Route::put('/inventory/update/{id}', [InventoryController::class, 'update'])->middleware('auth');

Route::get('/user/edit/{id}', [UserController::class, 'edit'])->middleware('auth');

Route::put('/user/update/{id}', [UserController::class, 'update'])->middleware('auth');

Route::get('/shop/edit/{id}', [ShopController::class, 'edit'])->middleware('auth');

Route::put('/shop/update/{id}', [ShopController::class, 'update'])->middleware('auth');

// ============================== CREATE ==============================

Route::get('/inventory/create', [InventoryController::class, 'create'])->middleware('auth');

Route::post('/inventory/store', [InventoryController::class, 'store'])->middleware('auth');

Route::get('/shop/create', [ShopController::class, 'create'])->middleware('auth');

Route::post('/shop/store', [ShopController::class, 'store'])->middleware('auth');

// ============================== DELETE ==============================

Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])->middleware('auth');

Route::delete('/user/{id}', [UserController::class, 'destroy'])->middleware('auth');

Route::delete('/shop/{id}', [ShopController::class, 'destroy'])->middleware('auth');

Route::delete('/transaction/delete/{type}/{id}', [TransactionController::class, 'destroy'])->middleware('auth');

Auth::routes();

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
