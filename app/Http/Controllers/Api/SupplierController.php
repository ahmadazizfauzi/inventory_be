<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Retrieve list of all suppliers with server-side pagination
    public function index(Request $request): JsonResponse
    {
        $query = Supplier::query()
            ->when($request->query('search'), function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('contact_info', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($request->query('start_date'), fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($request->query('end_date'), fn ($q, $date) => $q->whereDate('created_at', '<=', $date))
            ->latest();

        // If explicit all=true requested (e.g. for dropdown selects)
        if ($request->boolean('all')) {
            $suppliers = $query->get();
            return ApiResponse::success(SupplierResource::collection($suppliers), 'Daftar supplier berhasil dimuat');
        }

        $perPage = min(100, max(1, (int) $request->query('per_page', 10)));
        $paginated = $query->paginate($perPage);
        $paginated->through(fn ($supplier) => new SupplierResource($supplier));

        return ApiResponse::paginated($paginated, 'Daftar supplier berhasil dimuat');
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
