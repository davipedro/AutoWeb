<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index()
    {
        $response = VehicleRepository::getVehicles();
        $content = $response->getData();

        $veiculos = collect($content->data)->map(function ($veiculo) {
            $veiculo->valor_custo = number_format($veiculo->valor_custo, 2, ',', '.');
            $veiculo->valor_venda = number_format($veiculo->valor_venda, 2, ',', '.');
            $veiculo->ano = (string) $veiculo->ano;
            $veiculo->quilometragem = number_format($veiculo->quilometragem, 0, ',', '.');
            return $veiculo;
        });

        $veiculosArray = [
            'itens' => $veiculos,
            'count' => $content->count ?? 0,
        ];

        return view('vehicles.list', compact('veiculosArray'));
    }

    public function createVehicle()
    {
        $statuses = Status::all();
        return view('vehicles.add', compact('statuses'));
    }

    public function store(Request $request)
    {
        $rules = Vehicle::verifyInfo();

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            if (VehicleRepository::existsPlaca($request->placa)) {
                $validator->errors()->add('placa', 'Já existe um veículo cadastrado com essa placa.');
            }
            if ($request->filled('chassi') && VehicleRepository::existsChassi($request->chassi)) {
                $validator->errors()->add('chassi', 'Já existe um veículo cadastrado com esse chassi.');
            }
        });

        $validated = $validator->validate();

        $veiculo = VehicleRepository::create($validated);

        return redirect()->route('veiculos.list')->with('success', 'Veículo cadastrado com sucesso!');
    }


    public function edit($id)
    {
        $statusList = Status::all();
        return view('veiculos.edit', compact('veiculo', 'statusList'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(Vehicle::verifyInfo());

        $veiculo = Vehicle::findOrFail($id);
        $veiculo->update($validated);

        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }

    public function delete($id)
    {
        VehicleRepository::delete($id);
        return redirect()->route('veiculos.list')->with('success', 'Veículo removido com sucesso!');
    }
}
