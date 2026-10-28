
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Produto | Doces Gestão</title>

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

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
            background: #fff;
            color: #333;
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

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
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

        @media (max-width: 600px) {
            body {
                padding: 20px 12px;
            }

            .card {
                padding: 20px;
            }

            .actions {
                flex-direction: column;
            }

            .button {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        @include('layouts.navigation')

        <div class="card">
            <h1>Novo produto</h1>
            <p class="subtitle">
                Preencha os dados para cadastrar um produto.
            </p>

            @if ($errors->any())
                <div class="error">
                    Verifique os campos destacados e tente novamente.
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="field">
                    <label for="name">Nome do produto *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="category">Categoria *</label>
                    <select id="category" name="category" required>
                        <option value="">Selecione uma categoria</option>
                        <option value="Bolos" {{ old('category') == 'Bolos' ? 'selected' : '' }}>Bolos</option>
                        <option value="Doces" {{ old('category') == 'Doces' ? 'selected' : '' }}>Doces</option>
                        <option value="Salgados" {{ old('category') == 'Salgados' ? 'selected' : '' }}>Salgados</option>
                        <option value="Bebidas" {{ old('category') == 'Bebidas' ? 'selected' : '' }}>Bebidas</option>
                    </select>
                    @error('category')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="description">Descrição</label>
                    <textarea
                        id="description"
                        name="description"
                    >{{ old('description') }}</textarea>
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
                        value="{{ old('price') }}"
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
                        value="{{ old('stock_quantity', 0) }}"
                        required
                    >
                    @error('stock_quantity')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="minimum_stock">Estoque mínimo *</label>
                    <input
                        type="number"
                        id="minimum_stock"
                        name="minimum_stock"
                        min="0"
                        step="1"
                        value="{{ old('minimum_stock', 0) }}"
                        required
                    >
                    @error('minimum_stock')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <button type="submit" class="button primary">
                        Salvar produto
                    </button>

                    <a
                        href="{{ route('products.index') }}"
                        class="button secondary"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
