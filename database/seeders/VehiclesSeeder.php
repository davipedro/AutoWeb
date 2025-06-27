<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
{
    public function run(): void
    {
        Vehicle::factory()->count(100)->create();
    }
}
