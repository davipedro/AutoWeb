<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index()
    {
        $veiculos = $this->getVehicles();

        return view('vehicles.list', compact('veiculos'));
    }


    public function createVehicle()
    {
        $statuses = Status::all();
        return view('vehicles.add', compact('statuses'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateData($request);
            VehicleRepository::create($validated);
            return redirect()->route('veiculos.list')->with('success', 'Veículo cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar veículo: ' . $e->getMessage());
        }
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
        try {
            if (!$this->isVehicleAvailable($id)) {
                return redirect()->route('veiculos.list')
                    ->with('error', 'Veículo não disponível para edição.');
            }

            $validated = $this->validateData($request, $id);

            VehicleRepository::update($id, $validated);

            return redirect()->route('veiculos.list')->with('success', 'Veículo atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar veículo: ' . $e->getMessage());
        }
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

    public static function getNumberOfVehicles()
    {
        return Vehicle::count();
    }

    public static function getTotalValueOfVehicles()
    {
        return Vehicle::sum('valor_custo');
    }

    protected function isVehicleAvailable(int $id): bool
    {
        $vehicle = VehicleRepository::find($id);

        if (!$vehicle) {
            return false;
        }

        // Disponível se status_id != 12 e não deletado
        return $vehicle->status_id != 12 && $vehicle->deleted_at === null;
    }

    public static function getVehicles()
    {
        $currentRoute = Route::currentRouteName();

        // Se a rota for "catalogo", retorna todos (scroll infinito)
        if ($currentRoute === 'catalogo') {
            $veiculos = VehicleRepository::getVehiclesCatalog();
        }
        else {
            // Se não for a rota de catálogo, retorna apenas os veículos disponíveis
            $veiculos = VehicleRepository::getVehicles();

            $veiculos->getCollection()->transform(function ($veiculo) {
                $veiculo->valor_custo = number_format($veiculo->valor_custo, 2, ',', '.');
                $veiculo->valor_venda = number_format($veiculo->valor_venda, 2, ',', '.');
                $veiculo->ano = (string) $veiculo->ano;
                $veiculo->quilometragem = number_format($veiculo->quilometragem, 0, ',', '.');
                return $veiculo;
            });


        }

        return $veiculos;
    }

}
