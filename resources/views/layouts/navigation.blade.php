
<nav class="main-nav">
    <a href="{{ route('products.index') }}"
       class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        Produtos
    </a>

    <a href="{{ route('sales.index') }}"
       class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
        Vendas
    </a>

    <a href="{{ route('stock.index') }}"
       class="{{ request()->routeIs('stock.*') ? 'active' : '' }}">
        Estoque
    </a>
</nav>

<style>
    .main-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 20px 0 28px;
        padding: 8px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .main-nav a {
        padding: 11px 18px;
        border-radius: 6px;
        color: #4b5563;
        text-decoration: none;
        font-weight: 600;
        transition: background .2s, color .2s;
    }

    .main-nav a:hover {
        background: #f3f4f6;
        color: #111827;
    }

    .main-nav a.active {
        background: #2563eb;
        color: #fff;
    }
</style>
