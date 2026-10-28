
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas | Doces Gestão</title>
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
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }
        h1 { margin: 0 0 8px; }
        .muted { color: #6b7280; }
        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 24px;
            overflow-x: auto;
        }
        .button {
            display: inline-block;
            padding: 12px 16px;
            border-radius: 6px;
            background: #2563eb;
            color: white;
            text-decoration: none;
        }
        .button:hover { background: #1d4ed8; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        th { color: #6b7280; font-size: 13px; }
        .success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .empty { text-align: center; padding: 35px; color: #6b7280; }
        .back { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
<main class="container">
    @include('layouts.navigation')
    <div class="header">
        <div>
            <h1>Vendas</h1>
            <div class="muted">Consulte o histórico de vendas realizadas.</div>
        </div>
        <a class="button" href="{{ route('sales.create') }}">+ Nova venda</a>
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
        @if ($sales->isEmpty())
            <div class="empty">
                <h3>Nenhuma venda registrada</h3>
                <p>Registre sua primeira venda para começar o histórico.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Venda</th>
                        <th>Data</th>
                        <th>Produtos</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td>#{{ $sale->id }}</td>
                            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @foreach ($sale->items as $item)
                                    <div>
                                        {{ $item->product->name }}
                                        ({{ $item->quantity }} un.)
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                R$ {{ number_format((float) $sale->total, 2, ',', '.') }}
                            </td>
                            <td>{{ ucfirst($sale->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
</main>
</body>
</html>
