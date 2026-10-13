<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockMutation\StoreStockMutationRequest;
use App\Http\Resources\StockMutationResource;
use App\Services\StockMutation\StockMutationService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockMutationController extends Controller
{
    public function __construct(private readonly StockMutationService $mutationService) {}

    // Retrieve paginated stock mutation history
    public function index(Request $request): JsonResponse
    {
        $perPage = min(100, max(1, (int) $request->query('per_page', 10)));
        $productId = $request->query('product_id') ? (int) $request->query('product_id') : null;
        $startDate = $request->query('start_date') ? (string) $request->query('start_date') : null;
        $endDate = $request->query('end_date') ? (string) $request->query('end_date') : null;

        $paginated = $this->mutationService->paginate($perPage, $productId, $startDate, $endDate);
        $paginated->through(fn ($mutation) => new StockMutationResource($mutation));

        return ApiResponse::paginated($paginated, 'Riwayat mutasi stok berhasil dimuat');
    }

    // Record stock mutation (IN / OUT) and update product balance
    public function store(StoreStockMutationRequest $request): JsonResponse
    {
        $userId = (int) auth('api')->id();
        $mutation = $this->mutationService->record($request->validated(), $userId);

        return ApiResponse::created(
            new StockMutationResource($mutation),
            'Mutasi stok berhasil dicatat'
        );
    }
}
