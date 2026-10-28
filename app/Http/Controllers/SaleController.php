<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('items.product')
            ->latest()
            ->get();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $sale = Sale::create([
                'total' => 0,
                'status' => 'concluida',
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];

                if ($product->stock_quantity < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => "Estoque insuficiente para o produto {$product->name}. Disponível: {$product->stock_quantity}.",
                    ]);
                }

                $unitPrice = (float) $product->price;
                $subtotal = round($unitPrice * $quantity, 2);

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock_quantity', $quantity);

                $total += $subtotal;
            }

            $sale->update([
                'total' => round($total, 2),
            ]);
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Venda registrada com sucesso!');
    }
}
