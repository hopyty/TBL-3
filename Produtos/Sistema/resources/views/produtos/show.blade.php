@extends('layouts.app')
@section('title', 'Detalhes do produto')
@section('content')
@php($isArray = is_array($produto))
@php($id = $isArray ? $produto['id'] : $produto->id)
@php($nome = $isArray ? $produto['nome'] : $produto->nome)
@php($preco = $isArray ? $produto['preco'] : $produto->preco)
@php($ativo = $isArray ? $produto['ativo'] : $produto->ativo)
<div class="topo"><div><h1>Detalhes do produto</h1><div class="muted">Código #{{ $id }}</div></div><div class="acoes"><a class="btn secundario" href="{{ route('produtos.index') }}">← Voltar</a><a class="btn primario" href="{{ route('produtos.edit', $id) }}">Editar</a></div></div>
<div class="card"><h2 style="margin-top:0">{{ $nome }}</h2><div class="detalhe"><div><div class="muted">Identificador</div><strong>#{{ $id }}</strong></div><div><div class="muted">Preço</div><strong>R$ {{ number_format((float)$preco, 2, ',', '.') }}</strong></div><div><div class="muted">Status</div><span class="status {{ $ativo ? 'ativo' : 'inativo' }}">{{ $ativo ? 'Ativo' : 'Inativo' }}</span></div></div></div>
@endsection
