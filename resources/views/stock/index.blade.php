
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque | Doces Gestão</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 35px 20px;
            font-family: Arial, sans-serif;
            background: #f4f5f7;
            color: #333;
        }

        .container { max-width: 1100px; margin: auto; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 { margin: 0 0 8px; }
        h2 { margin-top: 0; font-size: 20px; }
        .muted { color: #6b7280; }

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 24px;
            margin-bottom: 24px;
            overflow-x: auto;
        }

        .button {
            display: inline-block;
            padding: 12px 16px;
            border: none;
            border-radius: 6px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .button:hover { background: #1d4ed8; }

        .back { color: #2563eb; text-decoration: none; }

        .field { margin-bottom: 18px; }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th { color: #6b7280; font-size: 13px; }

        .success {
            padding: 13px;
            margin-bottom: 20px;
            background: #dcfce7;
            color: #166534;
            border-radius: 6px;
        }

        .error {
            color: #b91c1c;
            font-size: 14px;
            margin-top: 6px;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #6b7280;
        }

        .stock-low { color: #b91c1c; font-weight: bold; }

        @media (max-width: 600px) {
            body { padding: 20px 12px; }
            .card { padding: 16px; }
        }
    </style>
</head>
<body>
<main class="container">
    @include('layouts.navigation')
    <div class="header">
        <div>
            <h1>Controle de estoque</h1>
            <div class="muted">Consulte os saldos e registre entradas de produtos.</div>
        </div>
        <a class="button" href="{{ route('products.index') }}">Ver produtos</a>
    </div>

    <p><a class="back" href="{{ route('products.index') }}">← Voltar para produtos</a></p>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="success" style="background:#fee2e2;color:#991b1b">
            {{ $errors->first() }}
        </div>
    @endif

    <section class="card">
        <h2>Registrar entrada</h2>
        <p class="muted">Informe o produto e a quantidade que está entrando no estoque.</p>

        @if ($products->isEmpty())
            <p>Nenhum produto cadastrado. Cadastre um produto antes de movimentar o estoque.</p>
            <a class="button" href="{{ route('products.create') }}">Cadastrar produto</a>
        @else
            <form action="{{ route('stock.store') }}" method="POST">
                @csrf

                <div class="field">
                    <label for="product_id">Produto *</label>
                    <select id="product_id" name="product_id" required>
                        <option value="">Selecione um produto</option>
                        @foreach ($products as $product)
                            <option
                                value="{{ $product->id }}"
                                @selected(old('product_id') == $product->id)
                            >
                                {{ $product->name }} — estoque atual: {{ $product->stock_quantity }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="quantity">Quantidade de entrada *</label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="1"
                        step="1"
                        value="{{ old('quantity', 1) }}"
                        required
                    >
                    @error('quantity')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="description">Observação (opcional)</label>
                    <input
                        type="text"
                        id="description"
                        name="description"
                        maxlength="255"
                        value="{{ old('description') }}"
                        placeholder="Ex.: Reposição de mercadoria"
                    >
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="button">Registrar entrada</button>
            </form>
        @endif
    </section>

    <section class="card">
        <h2>Saldo atual dos produtos</h2>

        @if ($products->isEmpty())
            <div class="empty">Nenhum produto cadastrado.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço unitário</th>
                        <th>Quantidade em estoque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>R$ {{ number_format((float) $product->price, 2, ',', '.') }}</td>
                            <td class="{{ $product->stock_quantity < 5 ? 'stock-low' : '' }}">
                                {{ $product->stock_quantity }} unidades
                                @if ($product->stock_quantity < 5)
                                    (estoque baixo)
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

    <section class="card">
        <h2>Histórico de movimentações</h2>

        @if ($movements->isEmpty())
            <div class="empty">
                Nenhuma movimentação registrada até o momento.
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Quantidade</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movements as $movement)
                        <tr>
                            <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $movement->product->name }}</td>
                            <td>{{ ucfirst($movement->type) }}</td>
                            <td>{{ $movement->quantity }} unidades</td>
                            <td>{{ $movement->description ?: '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
</main>
</body>
</html>
