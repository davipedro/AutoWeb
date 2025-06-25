<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $veiculosDisponiveis = VehicleController::getNumberOfVehicles();
        $valorEstoque = VehicleController::getTotalValueOfVehicles();
        return view('admin.dashboard', compact('veiculosDisponiveis', 'valorEstoque'));
    }

    public function sellerDashboard()
    {
        $veiculosDisponiveis = VehicleController::getNumberOfAvailableVehicles();
        return view('seller.dashboard', compact('veiculosDisponiveis'));
    }
}
