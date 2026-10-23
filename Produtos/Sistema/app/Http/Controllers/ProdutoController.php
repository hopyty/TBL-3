<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Support\ProdutoRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProdutoController extends Controller
{
    private function demo(): bool
    {
        return filter_var(env('DEMO_PRODUTOS', false), FILTER_VALIDATE_BOOL);
    }

    public function index(Request $request)
    {
        $filtros = $request->validate([
            'nome' => ['nullable', 'string', 'max:120'],
            'preco_minimo' => ['nullable', 'numeric', 'min:0'],
            'preco_maximo' => ['nullable', 'numeric', 'min:0'],
            'ativo' => ['nullable', Rule::in(['0', '1'])],
            'ordenar' => ['nullable', Rule::in(['id', 'nome', 'preco'])],
            'direcao' => ['nullable', Rule::in(['asc', 'desc'])],
        ]);

        if ($this->demo()) {
            $produtos = ProdutoRepository::filtrar($filtros);
            return view('produtos.index', compact('produtos', 'filtros'));
        }

        $consulta = Produto::query();

        if ($request->filled('nome')) {
            $consulta->where('nome', 'like', '%' . $request->input('nome') . '%');
        }
        if ($request->filled('preco_minimo')) {
            $consulta->where('preco', '>=', $request->input('preco_minimo'));
        }
        if ($request->filled('preco_maximo')) {
            $consulta->where('preco', '<=', $request->input('preco_maximo'));
        }
        if ($request->input('ativo') === '1') {
            $consulta->where('ativo', true);
        } elseif ($request->input('ativo') === '0') {
            $consulta->where('ativo', false);
        }

        $ordenar = $request->input('ordenar', 'nome');
        $direcao = $request->input('direcao', 'asc');
        $produtos = $consulta->orderBy($ordenar, $direcao)->paginate(10)->withQueryString();

        return view('produtos.index', compact('produtos', 'filtros'));
    }

    public function create()
    {
        $produto = null;
        return view('produtos.form', compact('produto'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:120'],
            'preco' => ['required', 'numeric', 'min:0'],
            'ativo' => ['required', Rule::in(['0', '1'])],
        ]);
        $dados['ativo'] = $dados['ativo'] === '1';

        if ($this->demo()) {
            $produto = ProdutoRepository::criar($dados);
            return redirect()->route('produtos.index')->with('sucesso', "Produto #{$produto['id']} criado no modo demonstração.");
        }

        $produto = Produto::create($dados);
        return redirect()->route('produtos.index')->with('sucesso', 'Produto cadastrado com sucesso.');
    }

    public function show(string $id)
    {
        $produto = $this->obter($id);
        return view('produtos.show', compact('produto'));
    }

    public function edit(string $id)
    {
        $produto = $this->obter($id);
        return view('produtos.form', compact('produto'));
    }

    public function update(Request $request, string $id)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:120'],
            'preco' => ['required', 'numeric', 'min:0'],
            'ativo' => ['required', Rule::in(['0', '1'])],
        ]);
        $dados['ativo'] = $dados['ativo'] === '1';

        if ($this->demo()) {
            ProdutoRepository::atualizar($id, $dados);
        } else {
            $produto = Produto::findOrFail($id);
            $produto->update($dados);
        }
        return redirect()->route('produtos.index')->with('sucesso', 'Produto atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        if ($this->demo()) {
            ProdutoRepository::excluir($id);
        } else {
            Produto::findOrFail($id)->delete();
        }
        return redirect()->route('produtos.index')->with('sucesso', 'Produto excluído com sucesso.');
    }

    private function obter(string $id)
    {
        if ($this->demo()) {
            return ProdutoRepository::buscar($id);
        }
        return Produto::findOrFail($id);
    }
}
