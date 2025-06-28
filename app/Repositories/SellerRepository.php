<?php

namespace App\Repositories;

use App\Models\Seller;
use Illuminate\Support\Facades\DB;

class SellerRepository
{
    public static function all()
    {
        return DB::table('sellers')->get();
    }

    public static function find($id)
    {
        return DB::table('sellers')
            ->leftJoin('users', 'users.id', '=', 'sellers.user_id')
            ->select(
                'sellers.*',
                'users.email as email',
                'users.name as nome_completo'
            )
            ->where('sellers.id', $id)
            ->whereNull('sellers.deleted_at')
            ->first();
    }

    public static function create(array $data)
    {
        try{
            $vendedor = Seller::create($data);
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            \Log::error('Error creating seller: ' . $e->getMessage());
            return null;
        }
        return $vendedor->id;
    }

    public static function update($id, array $data)
    {
        try{
            $vendedor = Seller::find($id);
            if ($vendedor) {
                return $vendedor->update($data);
            }
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            \Log::error('Error updating seller: ' . $e->getMessage());
        }
        return false;
    }

    public static function delete($id)
    {
        $vendedor = Seller::find($id);
        if ($vendedor) {
            return $vendedor->delete();
        }
        return false;
    }

    public static function existsByCpf(string $cpf): bool
    {
        return Seller::where('cpf', $cpf)->exists();
    }

    public static function getFilteredSellers(array $filters = [])
    {
        $query = DB::table('sellers')
            ->select('sellers.*', 'users.email as email', 'users.name as nome_completo')
            ->leftJoin('users', 'users.id', '=', 'sellers.user_id')
            ->whereNull('sellers.deleted_at');

        // Filtros
        if (!empty($filters['nome'])) {
            $query->whereRaw('LOWER(users.name) LIKE ?', ['%' . strtolower($filters['nome']) . '%']);
        }

        // E‑mail
        if (!empty($filters['email'])) {
            $query->whereRaw('LOWER(users.email) LIKE ?', ['%' . strtolower($filters['email']) . '%']);
        }

        // Telefone
        if (!empty($filters['telefone'])) {
            $query->where('sellers.telefone', 'like', '%' . $filters['telefone'] . '%');
        }

        // Cidade
        if (!empty($filters['cidade'])) {
            $query->whereRaw('LOWER(sellers.cidade) LIKE ?', ['%' . strtolower($filters['cidade']) . '%']);
        }

        // Estado
        if (!empty($filters['estado'])) {
            $query->whereRaw('LOWER(sellers.estado) = ?', [strtolower($filters['estado'])]);
        }

        // CPF
        if (!empty($filters['cpf'])) {
            $query->where('sellers.cpf', 'like', '%' . $filters['cpf'] . '%');
        }

        return $query->orderBy('nome_completo', 'ASC')->paginate(10)->appends($filters);
    }

    public static function getAllCidades()
    {
        return Seller::whereNull('deleted_at')
            ->select('cidade')
            ->distinct()
            ->orderByRaw('LOWER(cidade)')
            ->pluck('cidade');
    }

    public static function getAllEstados()
    {
        return Seller::whereNull('deleted_at')
            ->select('estado')
            ->distinct()
            ->orderByDesc('estado')
            ->pluck('estado');
    }

    public static function findById($id)
    {
        $vendedor = Seller::find($id);
        if ($vendedor && !$vendedor->trashed()) {
            return $vendedor;
        }
        return null;
    }
}
