<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientRepository
{
    public static function all()
    {
        return DB::table('clients')->get();
    }

    public static function find($id)
    {
        return DB::table('clients')->where('id', $id)->first();
    }

    public static function create(array $data)
    {
        $client = Client::create($data);
        return $client->id;
    }

    public static function update($id, array $data)
    {
        return Client::where('id', $id)->update($data);
    }

    public static function delete($id)
    {
        $client = Client::find($id);
        if ($client) {
            return $client->delete();
        }
        return false;
    }

    public static function existsByCpf(string $cpf): bool
    {
        return Client::where('cpf', $cpf)->exists();
    }

    public static function getFilteredClients(array $filters = [])
    {
        $query = DB::table('clients')
            ->select('clients.*',)
            ->whereNull('clients.deleted_at');

        // Filtros
        if (!empty($filters['nome'])) {
            $query->where(DB::raw('LOWER(nome_completo)'), 'like', '%' . strtolower($filters['nome']) . '%');
        }

        if (!empty($filters['email'])) {
            $query->where(DB::raw('LOWER(clients.email)'), 'like', '%' . strtolower($filters['email']) . '%');
        }

        if (!empty($filters['telefone'])) {
            $query->where('telefone', 'like', '%' . $filters['telefone'] . '%');
        }

        if (!empty($filters['cidade'])) {
            $query->where(DB::raw('LOWER(clients.cidade)'), 'like', '%', strtolower($filters['cidade']));
        }

        if (!empty($filters['estado'])) {
            $query->where(DB::raw('LOWER(clients.estado)'), '=', strtolower($filters['estado']));
        }

        return $query->orderBy('clients.nome_completo', 'ASC')->paginate(10)->appends($filters);
    }

    public static function getAllCidades()
    {
        return Client::whereNull('deleted_at')
            ->select('cidade')
            ->distinct()
            ->orderByRaw('LOWER(cidade)')
            ->pluck('cidade');
    }

    public static function getAllEstados()
    {
        return Client::whereNull('deleted_at')
            ->select('estado')
            ->distinct()
            ->orderByDesc('estado')
            ->pluck('estado');
    }

    public static function findById($id)
    {
        $client = Client::find($id);
        if ($client && !$client->trashed()) {
            return $client;
        }
        return null;
    }

    public static function getAvailableClients()
    {
        $query = DB::table('clients')
            ->select('clients.*',)
            ->whereNull('clients.deleted_at');

        $clientesDisponiveis = $query->orderBy('clients.nome_completo', 'ASC')->get();

        return $clientesDisponiveis;
    }
}
