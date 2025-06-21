<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {})->middleware('home.redirect');

    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

        Route::prefix('/veiculos')->group(function () {
            Route::get('/', [VehicleController::class, 'index'])->name('veiculos.list');
            Route::get('/cadastrar', [VehicleController::class, 'create'])->name('veiculos.add');
            Route::post('/salvar', [VehicleController::class, 'store'])->name('veiculos.store');
            Route::delete('/{id}/excluir', [VehicleController::class, 'delete'])->name('veiculos.delete');
        });

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

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
