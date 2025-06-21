<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('pt_BR');

        // IDs de status buscados pelo nome
        $statusDisponivel   = DB::table('status')->where('nome', 'disponível')->value('id');
        $statusVendido      = DB::table('status')->where('nome', 'vendido')->value('id');
        $statusManutencao   = DB::table('status')->where('nome', 'manutencao')->value('id');
        $statusIndisponivel = DB::table('status')->where('nome', 'indisponivel')->value('id');
        $statusReservado    = DB::table('status')->where('nome', 'reservado')->value('id');

        $statusIds = array_filter([
            $statusDisponivel,
            $statusVendido,
            $statusManutencao,
            $statusIndisponivel,
            $statusReservado
        ]);

        $brands = [
            'Fiat', 'Chevrolet', 'Volkswagen', 'Ford', 'Toyota', 'Honda', 'Hyundai', 'Renault', 'Nissan',
            'Jeep', 'Peugeot', 'Citroën', 'Mitsubishi', 'Kia', 'Suzuki', 'BMW', 'Mercedes-Benz', 'Audi',
            'Volvo', 'Land Rover', 'Subaru', 'Tesla', 'Chery', 'JAC Motors', 'Lexus', 'Mazda', 'Dodge',
            'Mini', 'Jaguar'
        ];

        $models = [
            'Uno', 'Palio', 'Punto', 'Strada', 'Toro', 'Onix', 'Prisma', 'Cruze', 'Spin', 'S10',
            'Gol', 'Voyage', 'Fusca', 'Fox', 'Tiguan', 'Jetta', 'Passat', 'Corolla', 'Yaris',
            'Hilux', 'Civic', 'City', 'HR-V', 'Fit', 'Renegade', 'Compass', '3008', 'C3', 'ASX',
            'Sportage', 'Sorento', 'X1', 'X3', 'A3', 'A4', 'XC60', 'Discovery', 'Impreza',
            'Model S', 'Model 3', 'Tiggo', 'iEV20', 'Jac T40', 'RX', 'CX-5', 'Challenger',
            'Cooper', 'XF'
        ];

        $transmissions = ['anual', 'automatico', 'cvt', 'auto_dupla_emb'];
        $fuelTypes = ['gasolina', 'etanol', 'flex', 'diesel', 'eletrico', 'hibrido', 'gnv', 'hidrogenio', 'alcool'];

        $veiculos = [];

        for ($i = 0; $i < 100; $i++) {
            $valorCusto = $faker->randomFloat(2, 10000, 150000);

            $veiculos[] = [
                'marca' => $faker->randomElement($brands),
                'modelo' => $faker->randomElement($models),
                'cor' => $faker->safeColorName(),
                'ano' => $faker->numberBetween(2000, 2024),
                'quilometragem' => $faker->numberBetween(0, 300000),
                'tipo_combustivel' => $faker->randomElement($fuelTypes),
                'transmissao' => $faker->randomElement($transmissions),
                'valor_custo' => $valorCusto,
                'valor_venda' => $valorCusto + rand(3000, 20000),
                'placa' => strtoupper($faker->unique()->bothify('???-####')),
                'chassi' => strtoupper($faker->unique()->bothify(str_repeat('#', 17))),
                'status_id' => $faker->randomElement($statusIds),
                'observacoes' => $faker->optional()->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('vehicles')->insert($veiculos);
    }
}
