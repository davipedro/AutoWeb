<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {})->middleware('home.redirect')->name('home');

    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

        Route::prefix('veiculos')->group(function () {
            Route::get('/', [VehicleController::class, 'index'])->name('admin.veiculos.list');
            Route::get('/cadastrar', [VehicleController::class, 'createVehicle'])->name('admin.veiculos.add');
            Route::post('/salvar', [VehicleController::class, 'store'])->name('admin.veiculos.store');
            Route::get('/editar/{id}', [VehicleController::class, 'editVehicle'])->name('admin.veiculos.edit');
            Route::post('/atualizar/{id}', [VehicleController::class, 'update'])->name('admin.veiculos.update');
            Route::get('/excluir/{id}', [VehicleController::class, 'delete'])->name('admin.veiculos.delete');
        });

        Route::prefix('clientes')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('admin.clientes.list');
            Route::get('/cadastrar', [ClientController::class, 'createClient'])->name('admin.clientes.add');
            Route::post('/salvar', [ClientController::class, 'store'])->name('admin.clientes.store');
            Route::get('/editar/{id}', [ClientController::class, 'editClient'])->name('admin.clientes.edit');
            Route::post('/atualizar/{id}', [ClientController::class, 'update'])->name('admin.clientes.update');
            Route::get('/excluir/{id}', [ClientController::class, 'delete'])->name('admin.clientes.delete');
        });

        Route::prefix('sale')->group(function () {
            Route::get('/cadastrar', [SaleController::class, 'createSale'])->name('admin.sell.add');
            Route::post('/salvar', [SaleController::class, 'storeSale'])->name('admin.sell.store');
        });

        Route::get('/relatorio', [ReportController::class, 'adminReport'])->name('admin.report');

    });

    Route::prefix('seller')->middleware(['auth', 'seller'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'sellerDashboard'])->name('seller.dashboard');

        Route::prefix('clientes')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('seller.clientes.list');
            Route::get('/cadastrar', [ClientController::class, 'createClient'])->name('seller.clientes.add');
            Route::post('/salvar', [ClientController::class, 'store'])->name('seller.clientes.store');
        });

        Route::prefix('veiculos')->group(function () {
            Route::get('/', [VehicleController::class, 'index'])->name('seller.veiculos.list');
            Route::get('/cadastrar', [VehicleController::class, 'createVehicle'])->name('seller.veiculos.add');
            Route::post('/salvar', [VehicleController::class, 'store'])->name('seller.veiculos.store');
            Route::get('/editar/{id}', [VehicleController::class, 'editVehicle'])->name('seller.veiculos.edit');
            Route::post('/atualizar/{id}', [VehicleController::class, 'update'])->name('seller.veiculos.update');
            Route::get('/excluir/{id}', [VehicleController::class, 'delete'])->name('seller.veiculos.delete');
        });

        Route::prefix('sale')->group(function () {
            Route::get('/cadastrar', [SaleController::class, 'createSale'])->name('seller.sell.add');
            Route::post('/salvar', [SaleController::class, 'storeSale'])->name('seller.sell.store');
        });

        Route::get('/relatorio', [ReportController::class, 'sellerReport'])->name('seller.report');

    });

    Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalogo');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

require __DIR__.'/auth.php';
