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
       $validated = $this->validateData($request);

        $veiculo = VehicleRepository::create($validated);

        return redirect()->route('veiculos.list')->with('success', 'Veículo cadastrado com sucesso!');
    }


    public function editVehicle($id, Request $request)
    {
        // Busca o veículo pelo ID no banco
        $veiculo = Vehicle::findOrFail($id);

        $statuses = Status::all();

        return view('vehicles.edit', compact('veiculo', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateData($request, $id);

        VehicleRepository::update($id, $validated);

        return redirect()->route('veiculos.list')->with('success', 'Veículo atualizado com sucesso!');
    }

    public function delete($id)
    {
        VehicleRepository::delete($id);
        return redirect()->route('veiculos.list')->with('success', 'Veículo removido com sucesso!');
    }

    public function validateData(Request $request, $id = null)
    {
        $rules = Vehicle::verifyInfo($id);

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($validator) use ($request, $id) {
            // Ignorar o veículo com id $id na verificação de placa duplicada
            if (VehicleRepository::existsPlaca($request->placa, $id)) {
                $validator->errors()->add('placa', 'Já existe um veículo cadastrado com essa placa.');
            }

            if ($request->filled('chassi') && VehicleRepository::existsChassi($request->chassi, $id)) {
                $validator->errors()->add('chassi', 'Já existe um veículo cadastrado com esse chassi.');
            }
        });

        return $validator->validate();
    }

}
