@extends('layouts.app')
@section('title', 'Consulta de produtos')
@section('content')
<div class="topo">
    <div><h1>Produtos</h1><div class="muted">Consulte, filtre e gerencie o catálogo.</div></div>
    <a class="btn primario" href="{{ route('produtos.create') }}">＋ Novo produto</a>
</div>
<div class="card">
    <form action="{{ route('produtos.index') }}" method="GET" class="filtros">
        <div><label for="nome">Nome do produto</label><input id="nome" name="nome" value="{{ request('nome') }}" placeholder="Ex.: gamer"></div>
        <div><label for="preco_minimo">Preço mínimo (R$)</label><input id="preco_minimo" type="number" name="preco_minimo" min="0" step="0.01" value="{{ request('preco_minimo') }}" placeholder="0,00"></div>
        <div><label for="preco_maximo">Preço máximo (R$)</label><input id="preco_maximo" type="number" name="preco_maximo" min="0" step="0.01" value="{{ request('preco_maximo') }}" placeholder="999,00"></div>
        <div><label for="ativo">Status</label><select id="ativo" name="ativo"><option value="">Todos</option><option value="1" @selected(request('ativo') === '1')>Ativos</option><option value="0" @selected(request('ativo') === '0')>Inativos</option></select></div>
        <div><label for="ordenar">Ordenar por</label><select id="ordenar" name="ordenar"><option value="nome" @selected(request('ordenar','nome') === 'nome')>Nome</option><option value="preco" @selected(request('ordenar') === 'preco')>Preço</option><option value="id" @selected(request('ordenar') === 'id')>ID</option></select><input type="hidden" name="direcao" value="{{ request('direcao','asc') }}"></div>
        <div class="acoes"><button class="btn primario" type="submit">Filtrar</button><a class="btn secundario" href="{{ route('produtos.index') }}">Limpar</a></div>
    </form>
</div>
<div class="card">
    <div class="topo" style="margin-bottom:10px"><div><strong>Catálogo cadastrado</strong><div class="muted" style="margin-top:5px">Resultados encontrados: {{ is_countable($produtos) ? count($produtos) : $produtos->total() }}</div></div>
    @if(!request()->boolean('ordem_invertida'))
        <a class="muted" href="{{ request()->fullUrlWithQuery(['direcao' => request('direcao','asc') === 'asc' ? 'desc' : 'asc']) }}">Alternar ordem ↑↓</a>
    @endif
    </div>
    <div class="table-wrap"><table>
        <thead><tr><th>ID</th><th>Produto</th><th>Preço</th><th>Status</th><th style="text-align:right">Ações</th></tr></thead>
        <tbody>
        @forelse($produtos as $produto)
            @php($id = is_array($produto) ? $produto['id'] : $produto->id)
            @php($nome = is_array($produto) ? $produto['nome'] : $produto->nome)
            @php($preco = is_array($produto) ? $produto['preco'] : $produto->preco)
            @php($ativo = is_array($produto) ? $produto['ativo'] : $produto->ativo)
            <tr>
                <td style="color:#64748b">#{{ $id }}</td>
                <td><strong>{{ $nome }}</strong></td>
                <td class="preco">R$ {{ number_format((float)$preco, 2, ',', '.') }}</td>
                <td><span class="status {{ $ativo ? 'ativo' : 'inativo' }}">{{ $ativo ? 'Ativo' : 'Inativo' }}</span></td>
                <td><div class="acoes" style="justify-content:flex-end">
                    <a class="btn secundario" href="{{ route('produtos.show', $id) }}">Ver</a>
                    <a class="btn secundario" href="{{ route('produtos.edit', $id) }}">Editar</a>
                    <form method="POST" action="{{ route('produtos.destroy', $id) }}" onsubmit="return confirm('Deseja excluir este produto?')">@csrf @method('DELETE')<button class="btn perigo" type="submit">Excluir</button></form>
                </div></td>
            </tr>
        @empty
            <tr><td colspan="5" class="vazio">Nenhum produto encontrado. Tente alterar os filtros.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    @if(method_exists($produtos, 'links')) <div style="margin-top:18px">{{ $produtos->links() }}</div> @endif
</div>
@endsection
