<?php

namespace App\Support;

/**
 * Repositório didático em memória. Não substitui PostgreSQL e não persiste após reiniciar.
 */
class ProdutoRepository
{
    private static function &dados(): array
    {
        static $produtos = [
            ['id' => 1, 'nome' => 'Notebook Gamer', 'preco' => 4299.90, 'ativo' => true],
            ['id' => 2, 'nome' => 'Monitor', 'preco' => 899.00, 'ativo' => true],
            ['id' => 3, 'nome' => 'Teclado Mecânico', 'preco' => 249.90, 'ativo' => true],
            ['id' => 4, 'nome' => 'Mouse Gamer', 'preco' => 119.90, 'ativo' => false],
            ['id' => 5, 'nome' => 'Webcam HD', 'preco' => 159.90, 'ativo' => true],
            ['id' => 6, 'nome' => 'Headset Gamer', 'preco' => 329.90, 'ativo' => true],
            ['id' => 7, 'nome' => 'Cabo HDMI', 'preco' => 29.90, 'ativo' => false],
        ];
        return $produtos;
    }

    public static function todos(): array
    {
        return array_values(self::dados());
    }

    public static function buscar(string|int $id): array
    {
        foreach (self::dados() as $produto) {
            if ((int) $produto['id'] === (int) $id) return $produto;
        }
        abort(404, 'Produto não encontrado.');
    }

    public static function criar(array $dados): array
    {
        $produtos = &self::dados();
        $novoId = empty($produtos) ? 1 : max(array_column($produtos, 'id')) + 1;
        $produto = ['id' => $novoId] + $dados;
        $produtos[] = $produto;
        return $produto;
    }

    public static function atualizar(string|int $id, array $dados): void
    {
        $produtos = &self::dados();
        foreach ($produtos as &$produto) {
            if ((int) $produto['id'] === (int) $id) {
                $produto = ['id' => (int) $id] + $dados;
                return;
            }
        }
        abort(404, 'Produto não encontrado.');
    }

    public static function excluir(string|int $id): void
    {
        $produtos = &self::dados();
        foreach ($produtos as $i => $produto) {
            if ((int) $produto['id'] === (int) $id) {
                array_splice($produtos, $i, 1);
                return;
            }
        }
        abort(404, 'Produto não encontrado.');
    }

    public static function filtrar(array $filtros): array
    {
        $produtos = self::todos();
        if (!empty($filtros['nome'])) {
            $termo = mb_strtolower($filtros['nome']);
            $produtos = array_filter($produtos, fn ($p) => str_contains(mb_strtolower($p['nome']), $termo));
        }
        if (isset($filtros['preco_minimo']) && $filtros['preco_minimo'] !== '') {
            $produtos = array_filter($produtos, fn ($p) => $p['preco'] >= (float) $filtros['preco_minimo']);
        }
        if (isset($filtros['preco_maximo']) && $filtros['preco_maximo'] !== '') {
            $produtos = array_filter($produtos, fn ($p) => $p['preco'] <= (float) $filtros['preco_maximo']);
        }
        if (isset($filtros['ativo']) && $filtros['ativo'] !== '') {
            $ativo = $filtros['ativo'] === '1';
            $produtos = array_filter($produtos, fn ($p) => $p['ativo'] === $ativo);
        }
        $ordenar = $filtros['ordenar'] ?? 'nome';
        $direcao = ($filtros['direcao'] ?? 'asc') === 'desc' ? -1 : 1;
        usort($produtos, fn ($a, $b) => ($a[$ordenar] <=> $b[$ordenar]) * $direcao);
        return array_values($produtos);
    }
}
