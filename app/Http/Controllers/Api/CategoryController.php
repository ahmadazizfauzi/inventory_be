<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    // Retrieve list of all categories
    public function index(): JsonResponse
    {
        $categories = Category::withCount('products')->get();

        return ApiResponse::success(CategoryResource::collection($categories), 'Categories retrieved successfully');
    }

    // Create a new category
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return ApiResponse::created(new CategoryResource($category), 'Category created successfully');
    }

    // Retrieve single category detail
    public function show(int $id): JsonResponse
    {
        $category = Category::withCount('products')->findOrFail($id);

        return ApiResponse::success(new CategoryResource($category), 'Category retrieved successfully');
    }

    // Update existing category
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->update($request->validated());

        return ApiResponse::success(new CategoryResource($category), 'Category updated successfully');
    }

    // Delete category if it has no associated products
    public function destroy(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if ($category->products()->exists()) {
            return ApiResponse::badRequest('Cannot delete category because it has associated products.');
        }

        $category->delete();

        return ApiResponse::success(null, 'Category deleted successfully');
    }
}
