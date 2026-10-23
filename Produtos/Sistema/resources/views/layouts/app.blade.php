<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Produtos') — EstoqueWeb</title>
    <style>
        :root { --azul:#1769aa; --azul-escuro:#123b5d; --fundo:#f3f6fa; --texto:#1e293b; --borda:#dce4ec; }
        * { box-sizing:border-box; }
        body { margin:0; font-family:Inter,Segoe UI,Arial,sans-serif; background:var(--fundo); color:var(--texto); }
        header { background:linear-gradient(120deg,var(--azul-escuro),var(--azul)); color:white; padding:22px max(20px,calc((100% - 1120px)/2)); }
        .marca { font-size:21px; font-weight:800; letter-spacing:.3px; }
        .sub { opacity:.8; font-size:13px; margin-top:4px; }
        main { max-width:1120px; margin:30px auto; padding:0 20px 40px; }
        .topo { display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:22px; }
        h1 { margin:0 0 5px; font-size:27px; } .muted { color:#64748b; font-size:14px; }
        .card { background:white; border:1px solid var(--borda); border-radius:14px; padding:22px; box-shadow:0 4px 18px #18334d0b; margin-bottom:18px; }
        .filtros { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1fr auto; gap:12px; align-items:end; }
        label { display:block; font-size:12px; font-weight:700; color:#526174; margin-bottom:7px; }
        input,select { width:100%; padding:11px 12px; border:1px solid #cbd5e1; border-radius:8px; font:inherit; background:#fff; min-width:0; }
        .btn { display:inline-flex; justify-content:center; align-items:center; gap:6px; border:0; border-radius:8px; padding:11px 15px; font-weight:700; text-decoration:none; cursor:pointer; font-size:14px; white-space:nowrap; }
        .primario { color:#fff; background:var(--azul); } .secundario { color:#334155; background:#eaf0f6; } .perigo { color:#b42318; background:#fff0ee; }
        .acoes { display:flex; align-items:center; gap:7px; flex-wrap:wrap; }
        .mensagem { padding:13px 16px; border-radius:9px; background:#e8f7ee; color:#17653a; margin-bottom:18px; }
        .erro { color:#b42318; font-size:12px; margin-top:5px; }
        .table-wrap { overflow-x:auto; } table { border-collapse:collapse; width:100%; min-width:650px; }
        th { text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:#64748b; background:#f8fafc; }
        th,td { padding:15px 13px; border-bottom:1px solid #edf1f5; } tbody tr:hover { background:#fbfdff; }
        .preco { font-weight:750; font-variant-numeric:tabular-nums; }
        .status { display:inline-block; padding:5px 10px; border-radius:30px; font-size:12px; font-weight:700; }
        .ativo { background:#e7f7ed; color:#187443; } .inativo { background:#f1f5f9; color:#64748b; }
        .vazio { padding:35px 12px; text-align:center; color:#64748b; }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; } .campo { margin-bottom:16px; }
        .detalhe { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; } .detalhe div { background:#f8fafc; border-radius:9px; padding:17px; }
        footer { text-align:center; padding:20px; color:#8290a1; font-size:12px; }
        @media(max-width:900px) { .filtros { grid-template-columns:repeat(2,minmax(0,1fr)); } .filtros .acoes { grid-column:1/-1; } }
        @media(max-width:560px) { main { margin-top:20px; padding:0 12px 28px; } .card { padding:15px; } .filtros,.form-grid,.detalhe { grid-template-columns:1fr; } h1 { font-size:23px; } }
    </style>
</head>
<body>
<header>
    <div class="marca">▦ EstoqueWeb</div>
    <div class="sub">Gestão simples de produtos · Laravel + Eloquent</div>
</header>
<main>
    @if (session('sucesso')) <div class="mensagem">✓ {{ session('sucesso') }}</div> @endif
    @if ($errors->any())
        <div class="mensagem" style="background:#fff0ee;color:#9f2218">
            <strong>Verifique os campos:</strong>
            <ul>@foreach ($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul>
        </div>
    @endif
    @yield('content')
</main>
<footer>EstoqueWeb · Projeto acadêmico demonstrativo · Laravel / PostgreSQL</footer>
</body>
</html>
