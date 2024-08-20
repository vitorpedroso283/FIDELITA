<?php

namespace Database\Seeders;

use Database\Seeders\RewardSeeder;
use Database\Seeders\TokensTableSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chama todos os seeders aqui
        $this->call([
            RewardSeeder::class,
            TokensTableSeeder::class
        ]);
    }
}
