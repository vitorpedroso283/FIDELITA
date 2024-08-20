<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reward::create([
            'name' => 'Suco de Laranja',
            'required_points' => 5,
        ]);

        Reward::create([
            'name' => '10% de desconto',
            'required_points' => 10,
        ]);

        Reward::create([
            'name' => 'Almoço especial',
            'required_points' => 20,
        ]);
    }
}
