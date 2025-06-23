<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class Client extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'data_nascimento',
        'email',
        'telefone',
        'cpf',
        'rg',
        'endereco',
        'complemento',
        'cidade',
        'estado',
        'cep',
        'observacoes',
    ];

    public static function verifyInfo($id = null)
    {
        $today = now()->format('Y-m-d');
        $minDate = now()->subYears(18)->format('Y-m-d');

        return [
            'nome_completo'     => 'required|string|max:255',
            'data_nascimento'   => "required|date|before_or_equal:$minDate|before_or_equal:$today",
            'cpf'               => ['required', 'string', 'size:14', Rule::unique('clients')->ignore($id)],
            'rg'                => 'nullable|string|max:20',
            'email'             => ['required', 'email', 'max:255', Rule::unique('clients')->ignore($id)],
            'telefone'          => 'required',
            'endereco'          => 'nullable|string|max:255',
            'complemento'       => 'nullable|string|max:100',
            'cidade'            => 'required|string|max:100',
            'estado'            => 'required|string|size:2',
            'cep'               => ['nullable', 'string', 'size:9', 'regex:/^\d{5}-\d{3}$/'],
            'observacoes'       => 'nullable|string|max:1000',
        ];
    }

}
