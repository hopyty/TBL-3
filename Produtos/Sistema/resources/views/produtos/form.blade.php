@extends('layouts.app')
@section('title', $produto ? 'Editar produto' : 'Novo produto')
@section('content')
<div class="topo"><div><h1>{{ $produto ? 'Editar produto' : 'Novo produto' }}</h1><div class="muted">Preencha as informações abaixo.</div></div><a class="btn secundario" href="{{ route('produtos.index') }}">← Voltar</a></div>
<div class="card">
    @php($isArray = is_array($produto))
    @php($valor = fn($campo, $padrao = '') => old($campo, $produto ? ($isArray ? ($produto[$campo] ?? $padrao) : ($produto->$campo ?? $padrao)) : $padrao))
    <form method="POST" action="{{ $produto ? route('produtos.update', $isArray ? $produto['id'] : $produto->id) : route('produtos.store') }}">
        @csrf
        @if($produto) @method('PUT') @endif
        <div class="form-grid">
            <div class="campo"><label for="nome">Nome do produto *</label><input id="nome" name="nome" required maxlength="120" value="{{ $valor('nome') }}" placeholder="Ex.: Monitor UltraWide">@error('nome')<div class="erro">{{ $message }}</div>@enderror</div>
            <div class="campo"><label for="preco">Preço (R$) *</label><input id="preco" name="preco" type="number" required min="0" step="0.01" value="{{ $valor('preco') }}" placeholder="0,00">@error('preco')<div class="erro">{{ $message }}</div>@enderror</div>
            <div class="campo"><label for="ativo">Status *</label><select id="ativo" name="ativo" required><option value="1" @selected((string)$valor('ativo','1') === '1')>Ativo</option><option value="0" @selected((string)$valor('ativo','1') === '0')>Inativo</option></select></div>
        </div>
        <div class="acoes"><button class="btn primario" type="submit">Salvar produto</button><a class="btn secundario" href="{{ route('produtos.index') }}">Cancelar</a></div>
    </form>
</div>
@endsection
