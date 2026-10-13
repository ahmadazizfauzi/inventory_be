<?php

namespace App\Services\StockMutation;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockMutationService
{
    // Retrieve paginated stock mutations with relations
    public function paginate(int $perPage = 10, ?int $productId = null): LengthAwarePaginator
    {
        return StockMutation::query()
            ->with(['product', 'user', 'supplier'])
            ->when($productId, fn ($q, $id) => $q->where('product_id', $id))
            ->latest()
            ->paginate($perPage);
    }

    // Record stock mutation and update product balance inside database transaction
    public function record(array $data, int $userId): StockMutation
    {
        return DB::transaction(function () use ($data, $userId) {
            $product = Product::where('id', $data['product_id'])->lockForUpdate()->firstOrFail();

            $quantity = (int) $data['quantity'];
            $stockBefore = (int) $product->stock;

            if ($data['type'] === 'out' && $quantity > $stockBefore) {
                throw ValidationException::withMessages([
                    'quantity' => ["Stok tidak mencukupi. Stok yang tersedia saat ini adalah {$stockBefore}."],
                ]);
            }

            $stockAfter = $data['type'] === 'in'
                ? $stockBefore + $quantity
                : $stockBefore - $quantity;

            $product->update(['stock' => $stockAfter]);

            return StockMutation::create([
                'product_id' => $product->id,
                'user_id' => $userId,
                'supplier_id' => $data['supplier_id'] ?? null,
                'type' => $data['type'],
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'notes' => $data['notes'] ?? null,
            ])->load(['product', 'user', 'supplier']);
        });
    }
}
