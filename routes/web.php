<?php

use App\Http\Controllers\BUController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NonTradeCustomerController;
use App\Http\Controllers\SupplierController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Providers\RouteServiceProvider;

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

Route::get('/', function () {
    return redirect()->intended(RouteServiceProvider::HOME);
});


Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.show');
        Route::get('/status/{id}', [CustomerController::class, 'status'])->name('customer.status');
        Route::post('/apply', [CustomerController::class, 'apply'])->name('customer.apply');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::post('/update', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/save', [CustomerController::class, 'save'])->name('customer.save');
    });
    Route::prefix('non-trade-customer')->group(function () {
        Route::get('/', [NonTradeCustomerController::class, 'index'])->name('non-trade-customer.show');
        Route::get('/edit/{id}', [NonTradeCustomerController::class, 'edit'])->name('non-trade-customer.edit');
        Route::post('/update', [NonTradeCustomerController::class, 'update'])->name('non-trade-customer.update');
        Route::get('/create', [NonTradeCustomerController::class, 'create'])->name('non-trade-customer.create');
        Route::post('/save', [NonTradeCustomerController::class, 'save'])->name('non-trade-customer.save');
    });
    Route::prefix('supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('supplier.show');
        Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/save', [SupplierController::class, 'save'])->name('supplier.save');
        Route::get('/status/{id}', [SupplierController::class, 'status'])->name('supplier.status');
        Route::post('/apply', [SupplierController::class, 'apply'])->name('supplier.apply');
        Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::post('/update', [SupplierController::class, 'update'])->name('supplier.update');
    });
    Route::prefix('item')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('item.show');
        Route::get('/create', [ItemController::class, 'create'])->name('item.create');
        Route::post('/save', [ItemController::class, 'save'])->name('item.save');
        Route::get('/status/{id}', [ItemController::class, 'status'])->name('item.status');
        Route::post('/apply', [ItemController::class, 'apply'])->name('item.apply');
        Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
        Route::post('/update', [ItemController::class, 'update'])->name('item.update');
    });
    Route::prefix('business-unit')->group(function () {
        Route::get('/', [BUController::class, 'index'])->name('bu.show');
        Route::get('/create', [BUController::class, 'create'])->name('bu.create');
        Route::post('/save', [BUController::class, 'save'])->name('bu.save');
        Route::get('/edit/{id}', [BUController::class, 'edit'])->name('bu.edit');
        Route::post('/update', [BUController::class, 'update'])->name('bu.update');
        
    });
});

require __DIR__ . '/auth.php';
