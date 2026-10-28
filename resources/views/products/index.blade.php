
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos | Doces Gestão</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #252525;
        }

        header {
            background: #fff;
            padding: 22px 5%;
            border-bottom: 1px solid #e5e7eb;
        }

        header h1 {
            font-size: 22px;
        }

        header p {
            color: #777;
            margin-top: 6px;
            font-size: 14px;
        }

        main {
            max-width: 1150px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .topo p {
            color: #777;
            margin-top: 6px;
            font-size: 14px;
        }

        .botao {
            display: inline-block;
            padding: 12px 18px;
            border: 0;
            border-radius: 7px;
            background: #252525;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .painel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .painel h2 {
            padding: 20px;
            font-size: 17px;
            border-bottom: 1px solid #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 16px 20px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #fafafa;
            color: #666;
            font-weight: 600;
        }

        .estoque {
            display: inline-block;
            background: #f0f0f0;
            padding: 6px 10px;
            border-radius: 20px;
        }

        .mensagem {
            margin-bottom: 20px;
            padding: 14px;
            border-radius: 7px;
            background: #e8f5e9;
            color: #246b32;
        }

        .vazio {
            text-align: center;
            padding: 35px 20px;
            color: #777;
        }

        .acoes {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .link {
            color: #333;
            text-decoration: none;
        }

        .excluir {
            background: none;
            border: 0;
            color: #b42318;
            cursor: pointer;
            font-size: 14px;
        }

        @media (max-width: 700px) {
            .topo {
                align-items: flex-start;
                flex-direction: column;
            }

            .painel {
                overflow-x: auto;
            }

            table {
                min-width: 700px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Doces Gestão</h1>
        <p>Gerenciamento do negócio</p>
    </header>

    <main>
        <div class="topo">
            <div>
                <h2>Produtos</h2>
                <p>Gerencie os produtos e acompanhe o estoque.</p>
            </div>

            <a href="{{ route('products.create') }}" class="botao">
                + Novo produto
            </a>
        </div>

        @if (session('success'))
            <div class="mensagem">
                {{ session('success') }}
            </div>
        @endif

        <section class="painel">
            <h2>Produtos cadastrados</h2>

            @if ($products->isEmpty())
                <div class="vazio">
                    <p>Nenhum produto cadastrado ainda.</p>
                    <p style="margin-top: 8px">
                        Clique em "Novo produto" para começar.
                    </p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    @if ($product->description)
                                        <p style="color:#777; margin-top:5px">
                                            {{ $product->description }}
                                        </p>
                                    @endif
                                </td>

                                <td>
                                    R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                                </td>

                                <td>
                                    <span class="estoque">
                                        {{ $product->stock_quantity }} unidades
                                    </span>
                                </td>

                                <td>
                                    <div class="acoes">
                                        <a
                                            class="link"
                                            href="{{ route('products.edit', $product) }}"
                                        >
                                            Editar
                                        </a>

                                        <form
                                            action="{{ route('products.destroy', $product) }}"
                                            method="POST"
                                            onsubmit="return confirm('Deseja realmente excluir este produto?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button class="excluir" type="submit">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </section>
    </main>
</body>
</html>
