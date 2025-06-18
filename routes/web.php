<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('veiculos.list');
    });

    Route::get('/veiculos', [VehicleController::class, 'index'])->name('veiculos.list');

    Route::get('/veiculos/cadastrar', [VehicleController::class, 'createVehicle'])->name('veiculos.add');
    Route::post('/veiculos/salvar', [VehicleController::class, 'store'])->name('veiculos.store');

    Route::get('/veiculos/editar/{id}', [VehicleController::class, 'editVehicle'])->name('veiculos.edit');
    Route::post('/veiculos/atualizar/{id}', [VehicleController::class, 'update'])->name('veiculos.update');

    Route::get('/veiculos/excluir/{id}', [VehicleController::class, 'delete'])->name('veiculos.delete');

});

