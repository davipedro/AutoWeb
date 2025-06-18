<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert([
            ['nome' => 'disponível', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'vendido', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'indisponivel', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'reservado', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'manutencao', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'inativo', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
