<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {})->middleware('home.redirect');

    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::prefix('/veiculos')->group(function () {
            Route::get('/', [VehicleController::class, 'index'])->name('veiculos.list');
            Route::get('/cadastrar', [VehicleController::class, 'createVehicle'])->name('veiculos.add');
            Route::post('/salvar', [VehicleController::class, 'store'])->name('veiculos.store');
            Route::get('/editar/{id}', [VehicleController::class, 'editVehicle'])->name('veiculos.edit');
            Route::post('/atualizar/{id}', [VehicleController::class, 'update'])->name('veiculos.update');
            Route::get('/excluir/{id}', [VehicleController::class, 'delete'])->name('veiculos.delete');
        });

        Route::post('register', [RegisteredUserController::class, 'store']);
        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');
    });

    Route::prefix('seller')->middleware(['auth', 'seller'])->group(function () {
        Route::get('/dashboard', function () {
            return view('seller.dashboard');
        })->name('seller.dashboard');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
