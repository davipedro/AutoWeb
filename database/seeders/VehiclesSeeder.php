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
        $statusManutencao = DB::table('status')->where('nome', 'manutencao')->value('id');
        $statusIndisponivel = DB::table('status')->where('nome', 'indisponivel')->value('id');
        $statusReservado = DB::table('status')->where('nome', 'reservado')->value('id');

        DB::table('vehicles')->insert([
            [
                'marca'          => 'Toyota',
                'modelo'         => 'Corolla',
                'cor'            => 'Prata',
                'ano'            => 2020,
                'quilometragem'  => 30000.5,
                'tipo_combustivel'=> 'Gasolina',
                'transmissao'    => 'Automática',
                'valor_custo'     => 65000.00,
                'valor_venda'     => 72000.00,
                'chassi'         => '9BWZZZ377VT004251',
                'placa'          => 'UAI2U34',
                'status_id'      => $statusDisponivel,
                'observacoes' => 'Veículo em excelente estado, revisado recentemente.',
                'deleted_at'    => null, // Coluna opcional para soft delete
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'marca'          => 'Volkswagen',
                'modelo'         => 'Gol',
                'cor'            => 'Vermelho',
                'ano'            => 2018,
                'quilometragem'  => 50000.0,
                'tipo_combustivel' => 'Flex',
                'transmissao'    => 'Manual',
                'valor_custo'     => 32000.00,
                'valor_venda'     => 38000.00,
                'chassi'         => '9BWZZZ377VT004252',
                'placa'          => 'XYZ5678',
                'status_id'      => $statusVendido,
                'observacoes' => 'Vendido em 15/03/2023',
                'deleted_at'    => null, // Coluna opcional para soft delete
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'marca'          => 'Ford',
                'modelo'         => 'Fiesta',
                'cor'            => 'Azul',
                'ano'            => 2015,
                'quilometragem'  => 75000.2,
                'tipo_combustivel'=> 'Álcool',
                'transmissao'    => 'Automática',
                'valor_custo'     => 25000.00,
                'valor_venda'     => 29000.00,
                'chassi'         => null, // Chassi opcional
                'placa'          => 'ABC1234',
                'status_id'      => $statusManutencao,
                'observacoes' => 'Veículo inativo desde 01/01/2024. Motivo: acidente leve.',
                'deleted_at'    => null, // Coluna opcional para soft delete
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'marca'          => 'Fiat',
                'modelo'         => 'Fastback',
                'cor'            => 'Verde pantano',
                'ano'            => 2025,
                'quilometragem'  => 123000,
                'tipo_combustivel'=> 'Diesel',
                'transmissao'    => 'CVT',
                'valor_custo'     => 182750.00,
                'valor_venda'     => 200000.00,
                'chassi'         => '95PPE3TABRJNV3281',
                'placa'          => 'CFG6Y54',
                'status_id'      => $statusReservado,
                'observacoes' => 'Veículo reservado para exibição no CarFestival 2025.',
                'deleted_at'    => null, // Coluna opcional para soft delete
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'marca'          => 'Nissan',
                'modelo'         => 'Sentra',
                'cor'            => 'Azul escuro',
                'ano'            => 2022,
                'quilometragem'  => 15000.0,
                'tipo_combustivel'=> 'Gasolina',
                'transmissao'    => 'Automática Dupla Embreagem',
                'valor_custo'     => 175000.00,
                'valor_venda'     => 180000.00,
                'chassi'         => '4VJ3C95EY45CV6646',
                'placa'          => 'BRA2E19',
                'status_id'      => $statusIndisponivel,
                'observacoes' => 'Veículo indisponível para venda. Motivo: aguardando documentação.',
                'deleted_at'    => null, // Coluna opcional para soft delete
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
