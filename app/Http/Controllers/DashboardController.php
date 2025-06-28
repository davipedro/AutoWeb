<?php

namespace App\Http\Controllers;

use App\Enums\DashboardPeriodEnum;
use App\Models\Seller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $veiculosDisponiveis = VehicleController::getNumberOfVehicles();
        $valorEstoque = VehicleController::getTotalValueOfVehicles();
        $vendedoresAtivos = SellerController::getNumberOfSellers();
        return view('admin.dashboard', compact('veiculosDisponiveis', 'valorEstoque', 'vendedoresAtivos'));
    }

    public function sellerDashboard(Request $request)
    {
        $periodInput = $request->input('period', 'current_month');
        if (!DashboardPeriodEnum::isValid($periodInput)) {
            $periodInput = 'current_month';
        }
        $dashboardData = Seller::getDashboardData(auth()->user()->id ,$periodInput);

        return view('seller.dashboard', [
            'salesCount'             => $dashboardData['salesCount'],
            'totalSalesValue'        => $dashboardData['totalSalesValue'],
            'accumulatedCommissions' => $dashboardData['accumulatedCommissions'],
            'sales'                  => $dashboardData['sales'],
            'currentPeriod'          => $periodInput,
        ]);
    }
}
