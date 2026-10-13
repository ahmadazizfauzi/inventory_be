<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboardService) {}

    // Retrieve real-time financial valuation and stock monitoring summary
    public function summary(): JsonResponse
    {
        $summary = $this->dashboardService->getSummary();

        return ApiResponse::success($summary, 'Ringkasan dashboard berhasil dimuat');
    }
}
