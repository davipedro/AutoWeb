<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function adminReport()
    {
        return view('admin.report');
    }

    public function sellerReport()
    {
        return view('seller.report');
    }
}
