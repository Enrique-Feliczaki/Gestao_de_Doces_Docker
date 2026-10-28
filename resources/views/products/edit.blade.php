<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto | Doces Gestão</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            font-family: Arial, sans-serif;
            background: #f4f5f7;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        h1 {
            margin-top: 0;
            font-size: 26px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .error {
            color: #b91c1c;
            font-size: 14px;
            margin-top: 6px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            cursor: pointer;
            border: none;
        }

        .primary {
            background: #2563eb;
            color: white;
        }

        .secondary {
            background: #e5e7eb;
            color: #333;
        }

        .primary:hover {
            background: #1d4ed8;
        }

        .secondary:hover {
            background: #d1d5db;
        }
    </style>
</head>
<body>
    <main class="container">
        @include('layouts.navigation')
        <div class="card">
            <h1>Editar produto</h1>
            <p class="subtitle">
                Atualize os dados de {{ $product->name }}.
            </p>

            @if ($errors->any())
                <div class="error">
                    Verifique os campos destacados e tente novamente.
                </div>
            @endif

            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="name">Nome do produto *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $product->name) }}"
                        required
                    >
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="description">Descrição</label>
                    <textarea
                        id="description"
                        name="description"
                    >{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="price">Preço (R$) *</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        min="0.01"
                        step="0.01"
                        value="{{ old('price', $product->price) }}"
                        required
                    >
                    @error('price')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="stock_quantity">Quantidade em estoque *</label>
                    <input
                        type="number"
                        id="stock_quantity"
                        name="stock_quantity"
                        min="0"
                        step="1"
                        value="{{ old('stock_quantity', $product->stock_quantity) }}"
                        required
                    >
                    @error('stock_quantity')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <button type="submit" class="button primary">
                        Salvar alterações
                    </button>

                    <a href="{{ route('products.index') }}" class="button secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
