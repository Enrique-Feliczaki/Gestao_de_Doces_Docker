
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Venda | Doces Gestão</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 35px 20px;
            font-family: Arial, sans-serif;
            background: #f4f5f7;
            color: #333;
        }
        .container { max-width: 850px; margin: auto; }
        .card {
            background: white;
            padding: 28px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }
        h1 { margin-top: 0; }
        .muted { color: #6b7280; }
        .field { margin: 18px 0; }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        select, input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
        }
        .item {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(100px, 1fr) auto;
            gap: 12px;
            align-items: end;
            padding: 18px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .button {
            display: inline-block;
            border: none;
            border-radius: 6px;
            padding: 12px 16px;
            cursor: pointer;
            text-decoration: none;
            font-size: 15px;
        }
        .primary { background: #2563eb; color: white; }
        .secondary { background: #e5e7eb; color: #333; }
        .remove { background: #fee2e2; color: #991b1b; }
        .actions { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 25px; }
        .error {
            color: #b91c1c;
            font-size: 14px;
            margin-top: 6px;
        }
        .total {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            margin-top: 25px;
        }
        .back { color: #2563eb; text-decoration: none; }
        @media (max-width: 600px) {
            .item { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<main class="container">
    @include('layouts.navigation')
    <p><a class="back" href="{{ route('sales.index') }}">← Voltar para vendas</a></p>

    <section class="card">
        <h1>Nova venda</h1>
        <p class="muted">Adicione os produtos e as quantidades desta venda.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        @if ($products->isEmpty())
            <p>Não há produtos cadastrados. Cadastre um produto antes de registrar uma venda.</p>
            <a class="button secondary" href="{{ route('products.create') }}">Cadastrar produto</a>
        @else
            <form action="{{ route('sales.store') }}" method="POST" id="sale-form">
                @csrf

                <div id="items">
                    <div class="item">
                        <div class="field">
                            <label>Produto *</label>
                            <select name="items[0][product_id]" class="product-select" required>
                                <option value="">Selecione um produto</option>
                                @foreach ($products as $product)
                                    <option
                                        value="{{ $product->id }}"
                                        data-price="{{ $product->price }}"
                                        data-stock="{{ $product->stock_quantity }}"
                                        @if ($product->stock_quantity < 1) disabled @endif
                                    >
                                        {{ $product->name }}
                                        — R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                                        (estoque: {{ $product->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label>Quantidade *</label>
                            <input
                                type="number"
                                name="items[0][quantity]"
                                class="quantity-input"
                                min="1"
                                step="1"
                                value="1"
                                required
                            >
                        </div>

                        <button type="button" class="button remove remove-item">Remover</button>
                    </div>
                </div>

                <button type="button" class="button secondary" id="add-item">
                    + Adicionar produto
                </button>

                <div class="total">
                    Total estimado: R$ <span id="total">0,00</span>
                </div>

                <div class="actions">
                    <button type="submit" class="button primary">Registrar venda</button>
                    <a href="{{ route('sales.index') }}" class="button secondary">Cancelar</a>
                </div>
            </form>
        @endif
    </section>
</main>

<script>
    const itemsContainer = document.getElementById('items');
    const addButton = document.getElementById('add-item');
    const totalElement = document.getElementById('total');

    function updateTotal() {
        let total = 0;

        document.querySelectorAll('.item').forEach((item) => {
            const select = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');
            const option = select.options[select.selectedIndex];

            if (option && option.dataset.price && quantityInput.value) {
                total += Number(option.dataset.price) * Number(quantityInput.value);
            }
        });

        totalElement.textContent = total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function updateOptions() {
        const selectedValues = Array.from(
            document.querySelectorAll('.product-select')
        ).map(select => select.value).filter(Boolean);

        document.querySelectorAll('.product-select').forEach((select) => {
            Array.from(select.options).forEach((option) => {
                if (!option.value) return;

                const duplicate = selectedValues.includes(option.value)
                    && select.value !== option.value;

                const noStock = Number(option.dataset.stock) < 1;

                option.disabled = duplicate || noStock;
            });
        });
    }

    function addItem() {
        const firstItem = itemsContainer.querySelector('.item');
        const newItem = firstItem.cloneNode(true);
        const index = itemsContainer.querySelectorAll('.item').length;

        newItem.querySelectorAll('select, input').forEach((field) => {
            field.name = field.name.replace(/items\[\d+\]/, `items[${index}]`);

            if (field.tagName === 'SELECT') {
                field.selectedIndex = 0;
            } else {
                field.value = 1;
            }
        });

        itemsContainer.appendChild(newItem);
        updateOptions();
        updateTotal();
    }

    addButton?.addEventListener('click', addItem);

    itemsContainer?.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-item')) {
            const rows = itemsContainer.querySelectorAll('.item');

            if (rows.length > 1) {
                event.target.closest('.item').remove();
                updateOptions();
                updateTotal();
            }
        }
    });

    itemsContainer?.addEventListener('change', (event) => {
        if (event.target.classList.contains('product-select')) {
            updateOptions();
        }

        updateTotal();
    });

    itemsContainer?.addEventListener('input', updateTotal);

    updateOptions();
    updateTotal();
</script>
</body>
</html>
