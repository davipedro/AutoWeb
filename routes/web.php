<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;

Route::get('/veiculos', [VehicleController::class, 'index'])->name('veiculos.list');
Route::post('/veiculos/salvar', [VehicleController::class, 'store'])->name('veiculos.store');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/veiculos/cadastrar', [VehicleController::class, 'create'])->name('veiculos.add');

