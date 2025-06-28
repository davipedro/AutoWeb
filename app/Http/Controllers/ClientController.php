<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index(Request $request)
    {

        $filters = $request->only(['nome', 'email', 'telefone', 'cpf', 'cidade', 'estado']);
        $filtrosAtivos = collect($filters)->filter()->isNotEmpty();

        $clientes = ClientRepository::getFilteredClients($filters);

        if ($filtrosAtivos) {
            // Com filtro → extrai apenas das opções filtradas
            $collection = $clientes->getCollection();
            $cidades = $collection->pluck('cidade')->unique()->sort()->values();
            $estados = $collection->pluck('estado')->unique()->sortDesc()->values();
        } else {
            // Sem filtros → traz tudo do banco
            $cidades = ClientRepository::getAllCidades();
            $estados = ClientRepository::getAllEstados();
        }
        return view('clients.list', compact('clientes', 'filters', 'cidades', 'estados'));
    }


    public function createClient()
    {
        return view('clients.add',);
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'telefone' => preg_replace('/\D/', '', $request->input('telefone'))
            ]);
            $validated = $this->validateData($request);
            ClientRepository::create($validated);

            return redirect()->route('clientes.list')->with('success', 'Cliente cadastrado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar cliente: ' . $e->getMessage())->withInput();
        }
    }

    public function editClient($id, Request $request)
    {
        // Busca o veículo pelo ID no banco
        $cliente = Client::findOrFail($id);

        return view('clients.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        try {
            // (Opcional) Verifique se o cliente existe e não foi soft deleted
            $cliente = ClientRepository::findById($id);
            if (!$cliente) {
                return redirect()->route('clientes.list')
                    ->with('error', 'Cliente não encontrado ou indisponível para edição.');
            }

            $request->merge([
                'telefone' => preg_replace('/\D/', '', $request->input('telefone'))
            ]);

            // Validação dos dados
            $validated = $this->validateData($request, $id);

            // Atualização
            ClientRepository::update($id, $validated);

            return redirect()->route('clientes.list')->with('success', 'Cliente atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar cliente: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        ClientRepository::delete($id);
        return redirect()->route('clientes.list')->with('success', 'Cliente removido com sucesso!');
    }

    protected function validateData(Request $request, $id = null)
    {
        $rules = Client::verifyInfo($id);

        return Validator::make($request->all(), $rules)->validate();
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
        $veiculos = VehicleRepository::getVehiclesCatalog();
        return $veiculos;
    }

    public static function getAvailableClients()
    {
        return ClientRepository::getAvailableClients();
    }

}
