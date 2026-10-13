<?php

namespace App\Services\Product;

use App\Http\Requests\Product\ListProductRequest;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    // Retrieve paginated products with search and filtering
    public function paginate(ListProductRequest $request): LengthAwarePaginator
    {
        return Product::query()
            ->with('category')
            ->when($request->search(), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->categoryId(), fn ($q, $id) => $q->where('category_id', $id))
            ->when($request->stockStatus() === 'low_stock', fn ($q) => $q->whereColumn('stock', '<=', 'min_stock'))
            ->when($request->stockStatus() === 'out_of_stock', fn ($q) => $q->where('stock', 0))
            ->when($request->stockStatus() === 'in_stock', fn ($q) => $q->where('stock', '>', 0))
            ->when($request->startDate(), fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($request->endDate(), fn ($q, $date) => $q->whereDate('created_at', '<=', $date))
            ->orderBy($request->sortBy(), $request->sortOrder())
            ->paginate($request->perPage());
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->fresh(['category']);
    }

    public function delete(Product $product): bool
    {
        return (bool) $product->delete();
    }
}
