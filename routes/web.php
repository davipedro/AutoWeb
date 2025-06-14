<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('veiculos.list');
    });

    Route::get('/veiculos', [VehicleController::class, 'index'])->name('veiculos.list');
    Route::get('/veiculos/cadastrar', [VehicleController::class, 'create'])->name('veiculos.add');
    Route::post('/veiculos/salvar', [VehicleController::class, 'store'])->name('veiculos.store');
    Route::delete('/veiculos/{id}/excluir', [VehicleController::class, 'delete'])->name('veiculos.delete');

});

