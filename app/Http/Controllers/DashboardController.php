<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $veiculosDisponiveis = VehicleController::getNumberOfVehicles();
        $valorEstoque = VehicleController::getTotalValueOfVehicles();
        return view('dashboard', compact('veiculosDisponiveis', 'valorEstoque'));
    }
}
