<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Retrieve list of all categories
    public function index(Request $request): JsonResponse
    {
        $categories = Category::withCount('products')
            ->when($request->query('search'), function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->query('start_date'), fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($request->query('end_date'), fn ($q, $date) => $q->whereDate('created_at', '<=', $date))
            ->get();

        return ApiResponse::success(CategoryResource::collection($categories), 'Daftar kategori berhasil dimuat');
    }

    // Create a new category
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return ApiResponse::created(new CategoryResource($category), 'Kategori berhasil ditambahkan');
    }

    // Retrieve single category detail
    public function show(int $id): JsonResponse
    {
        $category = Category::withCount('products')->findOrFail($id);

        return ApiResponse::success(new CategoryResource($category), 'Data kategori berhasil dimuat');
    }

    // Update existing category
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->update($request->validated());

        return ApiResponse::success(new CategoryResource($category), 'Kategori berhasil diperbarui');
    }

    // Delete category if it has no associated products
    public function destroy(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if ($category->products()->exists()) {
            return ApiResponse::badRequest('Kategori tidak dapat dihapus karena masih terkait dengan produk.');
        }

        $category->delete();

        return ApiResponse::success(null, 'Kategori berhasil dihapus');
    }
}
