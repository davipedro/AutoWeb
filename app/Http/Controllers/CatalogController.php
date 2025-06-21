<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $veiculosDisponiveis = VehicleController::getVehicles();
        return view('catalog/catalogo', compact('veiculosDisponiveis'));
    }
}
