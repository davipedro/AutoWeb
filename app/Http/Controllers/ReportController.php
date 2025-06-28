<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function adminReport()
    {
        $vendedores = SellerController::getSellers();
        return view('admin.report', compact('vendedores'));
    }

    public function sellerReport()
    {
        return view('seller.report');
    }
}
