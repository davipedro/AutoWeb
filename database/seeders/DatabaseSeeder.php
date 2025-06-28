<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role' => 'seller',
            'name' => 'seller',
            'email' => 'seller@seller.com',
            'password' => Hash::make('sellerseller'),
        ]);

        DB::table('users')->insert([
            'role' => 'admin',
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('adminadmin'),
        ]);

        $this->call([
            VehiclesSeeder::class,
            SellerSeeder::class,
            SaleSeeder::class,
        ]);
    }
}
