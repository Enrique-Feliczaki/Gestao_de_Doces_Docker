<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();

        $movements = StockMovement::with('product')
            ->latest()
            ->get();

        return view('stock.index', compact('products', 'movements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'description' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::whereKey($validated['product_id'])
                ->firstOrFail();

            $quantity = (int) $validated['quantity'];

            $product->increment('stock_quantity', $quantity);

            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'entrada',
                'quantity' => $quantity,
                'description' => $validated['description'] ?? null,
            ]);
        });

        return redirect()
            ->route('stock.index')
            ->with('success', 'Entrada de estoque registrada com sucesso!');
    }
}
