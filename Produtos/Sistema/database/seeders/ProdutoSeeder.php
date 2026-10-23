<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = [
            ['nome' => 'Notebook Gamer', 'preco' => 4299.90, 'ativo' => true],
            ['nome' => 'Monitor', 'preco' => 899.00, 'ativo' => true],
            ['nome' => 'Teclado Mecânico', 'preco' => 249.90, 'ativo' => true],
            ['nome' => 'Mouse Gamer', 'preco' => 119.90, 'ativo' => false],
            ['nome' => 'Webcam HD', 'preco' => 159.90, 'ativo' => true],
            ['nome' => 'Headset Gamer', 'preco' => 329.90, 'ativo' => true],
            ['nome' => 'Cabo HDMI', 'preco' => 29.90, 'ativo' => false],
        ];

        foreach ($produtos as $produto) {
            Produto::updateOrCreate(['nome' => $produto['nome']], $produto);
        }
    }
}
