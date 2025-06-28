<?php

namespace App\Http\Controllers;

use App\Enums\VehicleStatusEnum;
use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['modelo', 'marca', 'ano', 'status']);
        $filtrosAtivos = collect($filters)->filter()->isNotEmpty();

        $veiculos = VehicleRepository::getFilteredVehicles($filters);

        if ($filtrosAtivos) {
            // Com filtro → extrai apenas das opções filtradas
            $collection = $veiculos->getCollection();
            $marcas = $collection->pluck('marca')->unique()->sort()->values();
            $anos = $collection->pluck('ano')->unique()->sortDesc()->values();
            $status = $collection->pluck('status')->unique()->sort()->values();
        } else {
            // Sem filtros → traz tudo do banco
            $marcas = VehicleRepository::getAllMarcas();
            $anos = VehicleRepository::getAllAnos();
            $status = VehicleStatusEnum::getAllValues();
        }
        return view('vehicles.list', compact('veiculos', 'filters', 'marcas', 'status', 'anos'));
    }


    public function createVehicle()
    {
        $statuses = VehicleStatusEnum::getAllValues();
        return view('vehicles.add', compact('statuses'));
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'valor_custo' => $this->sanitizeMoney($request->input('valor_custo')),
                'valor_venda' => $this->sanitizeMoney($request->input('valor_venda')),
            ]);

            $validated = $this->validateData($request);
            VehicleRepository::create($validated);
            return redirect()->route(auth()->user()->role . '.veiculos.list')->with('success', 'Veículo cadastrado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar veículo: ' . $e->getMessage())->withInput();
        }
    }

    public function editVehicle($id, Request $request)
    {
        // Busca o veículo pelo ID no banco
        $veiculo = Vehicle::findOrFail($id);

        $statuses = VehicleStatusEnum::getAllValues();

        return view('vehicles.edit', compact('veiculo', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        try {
            if (!$this->isVehicleAvailable($id)) {
                return redirect()->route(auth()->user()->role . '.veiculos.list')
                    ->with('error', 'Veículo não disponível para edição.');
            }

            $request->merge([
                'valor_custo' => $this->sanitizeMoney($request->input('valor_custo')),
                'valor_venda' => $this->sanitizeMoney($request->input('valor_venda')),
            ]);

            $validated = $this->validateData($request, $id);

            VehicleRepository::update($id, $validated);

            return redirect()->route(auth()->user()->role . '.veiculos.list')->with('success', 'Veículo atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar veículo: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        VehicleRepository::delete($id);
        return redirect()->route(auth()->user()->role . '.veiculos.list')->with('success', 'Veículo removido com sucesso!');
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

    public static function getNumberOfAvailableVehicles()
    {
        return VehicleRepository::getNumberOfAvailableVehicles();
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

        return $vehicle->status != VehicleStatusEnum::Inactive->value && $vehicle->deleted_at === null;
    }

    public static function getVehicles($vehicleId = null)
    {
        $veiculos = VehicleRepository::getVehiclesCatalog($vehicleId);
        return $veiculos;
    }

    private function sanitizeMoney(string|null $valor): float
    {
        if (!$valor) return 0;

        $limpo = preg_replace('/[^\d,]/', '', $valor); // remove R$ e pontos
        $limpo = str_replace(',', '.', $limpo); // troca vírgula por ponto
        return (float) $limpo;
    }

}
