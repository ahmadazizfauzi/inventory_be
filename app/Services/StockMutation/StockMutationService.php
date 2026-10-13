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
    public function paginate(
        int $perPage = 10,
        ?int $productId = null,
        ?string $startDate = null,
        ?string $endDate = null,
        ?string $search = null,
        ?string $type = null
    ): LengthAwarePaginator {
        return StockMutation::query()
            ->with(['product', 'user', 'supplier'])
            ->when($productId, fn ($q, $id) => $q->where('product_id', $id))
            ->when($type && in_array($type, ['in', 'out']), fn ($q) => $q->where('type', $type))
            ->when($startDate, fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($endDate, fn ($q, $date) => $q->whereDate('created_at', '<=', $date))
            ->when($search, function ($q, $kw) {
                $q->where(function ($query) use ($kw) {
                    $query->whereHas('product', fn ($p) => $p->where('name', 'like', "%{$kw}%")->orWhere('sku', 'like', "%{$kw}%"))
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$kw}%"))
                        ->orWhere('notes', 'like', "%{$kw}%");
                });
            })
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
