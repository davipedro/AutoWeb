<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\User;
use App\Repositories\SellerRepository;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    public function index(Request $request)
    {

        $filters = $request->only(['nome', 'email', 'telefone', 'cpf', 'cidade', 'estado']);
        $filtrosAtivos = collect($filters)->filter()->isNotEmpty();

        $vendedores = SellerRepository::getFilteredSellers($filters);

        $usuariosDisponiveis = $this->getSAvailableSellers();

        if ($filtrosAtivos) {
            // Com filtro → extrai apenas das opções filtradas
            $collection = $vendedores->getCollection();
            $cidades = $collection->pluck('cidade')->unique()->sort()->values();
            $estados = $collection->pluck('estado')->unique()->sortDesc()->values();
        } else {
            // Sem filtros → traz tudo do banco
            $cidades = SellerRepository::getAllCidades();
            $estados = SellerRepository::getAllEstados();
        }
        return view('sellers.list', compact('vendedores', 'filters', 'cidades', 'estados', 'usuariosDisponiveis'));
    }


    public function createSeller()
    {
        $usuariosDisponiveis = $this->getSAvailableSellers();

        if ($usuariosDisponiveis->isEmpty()) {
            return redirect()->route('admin.vendedores.list')->with('error', 'Não há usuários disponíveis para vincular como vendedores.');
        } else {
            return view('sellers.add', [
                'usuarios' => $usuariosDisponiveis,
            ]);
        }
    }

    public static function getSAvailableSellers()
    {
        // IDs de usuários que já são vendedores
        $userIdsVinculados = Seller::pluck('user_id')->toArray();

        // Usuários que ainda não têm vendedor associado
        $usuariosDisponiveis = User::whereNotIn('id', $userIdsVinculados)->where('role', '!=', 'admin')->get();

        return $usuariosDisponiveis;
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'telefone' => preg_replace('/\D/', '', $request->input('telefone')),
                'cpf' => preg_replace('/\D/', '', $request->input('cpf')),
            ]);
            $validated = $this->validateStoreData($request, null, $request->input('user_id'));
            SellerRepository::create($validated);

            return redirect()->route('admin.vendedores.list')->with('success', 'Vendedor cadastrado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar vendedor: ' . $e->getMessage())->withInput();
        }
    }

    public function editSeller($id, Request $request)
    {
        // Busca o vendedor pelo ID no banco
        $vendedor = SellerRepository::find($id);

        return view('sellers.edit', compact('vendedor'));
    }

    public function update(Request $request, $id)
    {
        try {
            $vendedor = SellerRepository::findById($id);
            if (!$vendedor) {
                return redirect()->route('admin.vendedores.list')
                    ->with('error', 'Vendedor não encontrado ou indisponível para edição.');
            }

            $request->merge([
                'telefone' => preg_replace('/\D/', '', $request->input('telefone'))
            ]);

            $request->merge(['user_id' => $vendedor->user_id]);

            $validated = $this->validateData($request, $id, $vendedor->user_id);

            $sellerData = [
                'user_id' => $validated['user_id'],
                'telefone' => $validated['telefone'],
                'salario' => $validated['salario'] ?? null,
                'data_admissao' => $validated['data_admissao'],
                'cpf' => $validated['cpf'],
                'rg' => $validated['rg'] ?? null,
                'endereco' => $validated['endereco'] ?? null,
                'complemento' => $validated['complemento'] ?? null,
                'cidade' => $validated['cidade'],
                'estado' => $validated['estado'],
                'cep' => $validated['cep'] ?? null,
                'comissao' => $validated['comissao'] ?? null,
                'observacoes' => $validated['observacoes'] ?? null
            ];

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email']
            ];

            SellerRepository::update($id, $sellerData);
            UsersRepository::update($vendedor->user_id,  $userData);

            return redirect()->route('admin.vendedores.list')->with('success', 'Vendedor atualizado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar dados do vendedor: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        SellerRepository::delete($id);
        return redirect()->route('admin.vendedores.list')->with('success', 'Vendedor removido com sucesso!');
    }

    protected function validateData(Request $request, $id = null, $userId = null)
    {
        $sellerRules = Seller::verifyInfo($id, $userId);
        $userRules   = User::verifyInfo($userId);

        $rules = array_merge($sellerRules, $userRules);

        try {
            return Validator::make($request->all(), $rules)->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->validator->errors()->all());
        }
    }

    protected function validateStoreData(Request $request, $id = null, $userId = null)
    {
        $rules = Seller::verifyInfo($id, $userId);

        try {
            return Validator::make($request->all(), $rules)->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->validator->errors()->all());
        }
    }

    public static function getNumberOfSellers()
    {
        return Seller::whereNull('deleted_at')->count();
    }

    public static function getSellers()
    {
        return SellerRepository::getSellers();
    }

}
