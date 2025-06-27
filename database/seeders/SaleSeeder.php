<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seller - Vendas do mês atual
        Sale::factory()->count(10)->create([
            'vendedor_id' => 1,
            'data_venda' => now()->startOfMonth(),
        ]);
        // Seller - Vendas do mês passado
        Sale::factory()->count(10)->create([
            'vendedor_id' => 1,
            'data_venda' => now()->subMonth()->startOfMonth(),
        ]);
        // Seller - Vendas do último trimestre
        Sale::factory()->count(10)->create([
            'vendedor_id' => 1,
            'data_venda' => now()->subMonths(3)->startOfMonth(),
        ]);
        // Vendas Seller - do ano atual
        Sale::factory()->count(10)->create([
            'vendedor_id' => 1,
            'data_venda' => now()->startOfYear(),
        ]);

        // Vendas aleatórias
        Sale::factory()->count(50)->create();
    }
}
