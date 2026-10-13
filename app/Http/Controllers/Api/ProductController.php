<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ListProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Product\ProductService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService) {}

    // Retrieve paginated products with search, category filter, and stock alert status
    public function index(ListProductRequest $request): JsonResponse
    {
        $paginated = $this->productService->paginate($request);
        $paginated->through(fn ($product) => new ProductResource($product));

        return ApiResponse::paginated($paginated, 'Daftar produk berhasil dimuat');
    }

    // Create a new product
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());
        $product->load('category');

        return ApiResponse::created(new ProductResource($product), 'Produk berhasil ditambahkan');
    }

    // Retrieve single product detail
    public function show(int $id): JsonResponse
    {
        $product = Product::with('category')->findOrFail($id);

        return ApiResponse::success(new ProductResource($product), 'Data produk berhasil dimuat');
    }

    // Update existing product
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $updated = $this->productService->update($product, $request->validated());

        return ApiResponse::success(new ProductResource($updated), 'Produk berhasil diperbarui');
    }

    // Soft delete product
    public function destroy(int $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $this->productService->delete($product);

        return ApiResponse::success(null, 'Produk berhasil dihapus');
    }
}
