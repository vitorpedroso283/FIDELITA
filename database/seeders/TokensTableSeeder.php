<?php

namespace Database\Seeders;

use App\Models\Token;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria os tokens com permissões
        Token::create([
            'token' => '4b5f8f32c96a9aa152e0c6615d4e632f',
            'permissions' => ['001', '002', '003', '004', '005', '006'],
        ]);

        Token::create([
            'token' => '117ae721e424e7f819893edb2c0c5fd6',
            'permissions' => ['002', '003', '004'],
        ]);

        Token::create([
            'token' => '3b7d6e2cb06ba79a9c9744f8e256a39e',
            'permissions' => ['005', '006'],
        ]);
    }
}
