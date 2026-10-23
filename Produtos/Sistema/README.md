# Sistema Web de Produtos — Laravel + PostgreSQL (simulado)

Projeto didático baseado no material de aula sobre consultas e filtros com Eloquent.

## O que contém
- Rotas web nomeadas para listar, criar, visualizar, editar e excluir produtos.
- Model `Produto` com `id`, `nome`, `preco` e `ativo`.
- Controller com CRUD e filtros combináveis por nome, preço mínimo, preço máximo e status.
- Ordenação por nome, preço ou ID; paginação; mensagem quando não há resultados.
- Migration da tabela `produtos`.
- Seeder com dados demonstrativos.
- Configuração PostgreSQL em `.env.example`.
- **Modo demonstração**: `ProdutoRepository` usa dados em memória, sem precisar instalar PostgreSQL. Esse modo simula operações durante a execução; os dados voltam ao padrão quando o servidor reinicia.
- Modo PostgreSQL real: instruções de configuração incluídas.

## Requisitos
- PHP 8.2+
- Composer
- Laravel 11 ou 12 (crie um projeto Laravel limpo e copie os arquivos deste pacote para ele).
- Para PostgreSQL real: PostgreSQL e extensão PHP `pdo_pgsql`.

> Este pacote contém os arquivos da aplicação, não todo o framework Laravel. A estrutura é feita para ser copiada para um projeto Laravel padrão.

## Instalação
1. Crie o projeto:
   ```bash
   composer create-project laravel/laravel sistema-produtos
   ```
2. Copie as pastas/arquivos deste pacote para a pasta `sistema-produtos`, mesclando as pastas.
3. Copie `.env.example` para `.env` (ou ajuste o `.env` já criado).
4. Instale a chave e rode a aplicação:
   ```bash
   php artisan key:generate
   php artisan serve
   ```
5. Abra `http://127.0.0.1:8000/produtos`.

### Modo demonstração (sem PostgreSQL)
No `.env`, configure:
```env
DB_CONNECTION=pgsql
DEMO_PRODUTOS=true
```
A aplicação usa o repositório em memória quando `DEMO_PRODUTOS=true`. Isso **simula** o banco; não persiste dados entre reinicializações.

### Modo PostgreSQL real
1. Crie um banco, por exemplo `sistema_produtos`.
2. No `.env`, configure:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=sistema_produtos
   DB_USERNAME=postgres
   DB_PASSWORD=sua_senha
   DEMO_PRODUTOS=false
   ```
3. Confirme que a extensão `pdo_pgsql` está habilitada.
4. Execute:
   ```bash
   php artisan migrate --seed
   ```
5. Inicie:
   ```bash
   php artisan serve
   ```

## Rotas
| Método | URL | Finalidade |
|---|---|---|
| GET | `/` | Redireciona para produtos |
| GET | `/produtos` | Listagem, filtros e ordenação |
| GET | `/produtos/criar` | Formulário de cadastro |
| POST | `/produtos` | Salvar produto |
| GET | `/produtos/{id}` | Detalhes |
| GET | `/produtos/{id}/editar` | Formulário de edição |
| PUT/PATCH | `/produtos/{id}` | Atualizar |
| DELETE | `/produtos/{id}` | Excluir |

## Consultas Eloquent completas (conforme atividade)
```php
// 1. Todos os produtos ativos
$produtos = Produto::where('ativo', true)->get();

// 2. Preço maior que R$ 100,00
$produtos = Produto::where('preco', '>', 100)->get();

// 3. Produto de ID 5
$produto = Produto::find(5);

// 4. Primeiro produto chamado exatamente "Monitor"
$produto = Produto::where('nome', '=', 'Monitor')->first();

// 5. Do mais caro para o mais barato
$produtos = Produto::orderBy('preco', 'desc')->get();

// Exercício 2: ativos entre R$ 30,00 e R$ 250,00, ordenados por nome
$produtos = Produto::where('ativo', true)
    ->whereBetween('preco', [30, 250])
    ->orderBy('nome', 'asc')
    ->get();

// Exercício 3: nome contém "gamer"
$produtos = Produto::where('nome', 'like', '%gamer%')->get();
```

`where()` encadeado combina condições com `AND`. `gamer%` procura nomes que começam com “gamer”; `%gamer%` procura o termo em qualquer parte do nome. A sensibilidade a maiúsculas/minúsculas depende do banco e da configuração.

## Nota técnica
No modo PostgreSQL real, o CRUD usa Eloquent e persiste no banco. No modo demonstração, o repositório em memória simula CRUD e filtros, mas não é uma conexão PostgreSQL verdadeira. A escolha é controlada por `DEMO_PRODUTOS`.
