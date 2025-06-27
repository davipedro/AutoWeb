<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
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
            Route::get('/', [VehicleController::class, 'index'])->name('veiculos.list');
            Route::get('/cadastrar', [VehicleController::class, 'createVehicle'])->name('veiculos.add');
            Route::post('/salvar', [VehicleController::class, 'store'])->name('veiculos.store');
            Route::get('/editar/{id}', [VehicleController::class, 'editVehicle'])->name('veiculos.edit');
            Route::post('/atualizar/{id}', [VehicleController::class, 'update'])->name('veiculos.update');
            Route::get('/excluir/{id}', [VehicleController::class, 'delete'])->name('veiculos.delete');
        });

        Route::prefix('clientes')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('clientes.list');
            Route::get('/cadastrar', [ClientController::class, 'createClient'])->name('clientes.add');
            Route::post('/salvar', [ClientController::class, 'store'])->name('clientes.store');
            Route::get('/editar/{id}', [ClientController::class, 'editClient'])->name('clientes.edit');
            Route::post('/atualizar/{id}', [ClientController::class, 'update'])->name('clientes.update');
            Route::get('/excluir/{id}', [ClientController::class, 'delete'])->name('clientes.delete');
        });

        Route::get('/sellers/cadastrar', [SellerController::class, 'createSeller'])->name('sellers.add');

        Route::get('/relatorio', [ReportController::class, 'adminReport'])->name('admin.report');

    });

    Route::prefix('seller')->middleware(['auth', 'seller'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'sellerDashboard'])->name('seller.dashboard');

        Route::prefix('veiculos')->group(function () {
            Route::get('/', [VehicleController::class, 'index'])->name('veiculos.list');
            Route::get('/cadastrar', [VehicleController::class, 'createVehicle'])->name('veiculos.add');
            Route::post('/salvar', [VehicleController::class, 'store'])->name('veiculos.store');
        });

        Route::prefix('clientes')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('clientes.list');
            Route::get('/cadastrar', [ClientController::class, 'createClient'])->name('clientes.add');
            Route::post('/salvar', [ClientController::class, 'store'])->name('clientes.store');
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
