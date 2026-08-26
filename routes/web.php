<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ManufacturingFormulaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth Routes

Route::middleware(['guest'])->prefix('auth')->group(function () {
    Route::get('/login',[AuthController::class,'loginView'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('auth.login');
    Route::get('/register',[AuthController::class,'registerView'])->name('register');
    Route::post('/register',[AuthController::class,'register'])->name('auth.register');
});

Route::middleware(['auth','role:admin'])->group(function(){
        Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('admin.dashboard');

        Route::resource('products', ProductController::class);
        Route::resource('raw-materials', RawMaterialController::class)->except(['show']);
        Route::resource('manufacturing-formulas',ManufacturingFormulaController::class)->except(['show']);
        Route::resource('invoices',InvoiceController::class)->except(['show']);
        Route::resource('units', UnitController::class);

        Route::get('/purchase-requests/raw-material/{rawMaterial}',[PurchaseRequestController::class, 'rawMaterial'])->name('purchase-requests.raw-material');

        Route::resource('purchase-requests',PurchaseRequestController::class);

        Route::post('logout',[AuthController::class,'logout'])->name('logout');
});