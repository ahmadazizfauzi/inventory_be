<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    // Retrieve list of all suppliers
    public function index(): JsonResponse
    {
        $suppliers = Supplier::all();

        return ApiResponse::success(SupplierResource::collection($suppliers), 'Daftar supplier berhasil dimuat');
    }

    // Create a new supplier
    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = Supplier::create($request->validated());

        return ApiResponse::created(new SupplierResource($supplier), 'Supplier berhasil ditambahkan');
    }

    // Retrieve single supplier detail
    public function show(int $id): JsonResponse
    {
        $supplier = Supplier::findOrFail($id);

        return ApiResponse::success(new SupplierResource($supplier), 'Data supplier berhasil dimuat');
    }

    // Update existing supplier
    public function update(UpdateSupplierRequest $request, int $id): JsonResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->validated());

        return ApiResponse::success(new SupplierResource($supplier), 'Supplier berhasil diperbarui');
    }

    // Delete supplier
    public function destroy(int $id): JsonResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return ApiResponse::success(null, 'Supplier berhasil dihapus');
    }
}
