<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pegando os status existentes
        $statusDisponivel = DB::table('status')->where('nome', 'disponível')->value('id');
        $statusVendido = DB::table('status')->where('nome', 'vendido')->value('id');
        $statusInativo = DB::table('status')->where('nome', 'inativo')->value('id');

        DB::table('vehicles')->insert([
            [
                'marca'          => 'Toyota',
                'modelo'         => 'Corolla',
                'ano'            => 2020,
                'quilometragem'  => 30000.5,
                'tipo_combustivel'=> 'Gasolina',
                'valor_custo'     => 65000.00,
                'valor_venda'     => 72000.00,
                'chassi'         => '9BWZZZ377VT004251',
                'status_id'      => $statusDisponivel,
                'observacoes' => 'Veículo em excelente estado, revisado recentemente.',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'marca'          => 'Volkswagen',
                'modelo'         => 'Gol',
                'ano'            => 2018,
                'quilometragem'  => 50000.0,
                'tipo_combustivel' => 'Flex',
                'valor_custo'     => 32000.00,
                'valor_venda'     => 38000.00,
                'chassi'         => '9BWZZZ377VT004252',
                'status_id'      => $statusVendido,
                'observacoes' => 'Vendido em 15/03/2023',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'marca'          => 'Ford',
                'modelo'         => 'Fiesta',
                'ano'            => 2015,
                'quilometragem'  => 75000.2,
                'tipo_combustivel'=> 'Álcool',
                'valor_custo'     => 25000.00,
                'valor_venda'     => 29000.00,
                'chassi'         => null, // Chassi opcional
                'status_id'      => $statusInativo,
                'observacoes' => 'Veículo inativo desde 01/01/2024. Motivo: acidente leve.',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
