<?php

namespace App\Services\Dashboard;

use App\Models\Product;
use App\Models\StockMutation;

class DashboardService
{
    // Calculate real-time financial valuation and stock metrics
    public function getSummary(): array
    {
        $totalItems = Product::count();

        $totalAssetValue = (float) Product::selectRaw('COALESCE(SUM(stock * purchase_price), 0) as total')->value('total');
        $totalMarketValue = (float) Product::selectRaw('COALESCE(SUM(stock * selling_price), 0) as total')->value('total');
        $potentialProfit = (float) Product::selectRaw('COALESCE(SUM(stock * (selling_price - purchase_price)), 0) as total')->value('total');

        $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')->where('stock', '>', 0)->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();
        $todayMutations = StockMutation::whereDate('created_at', today())->count();

        $valuationTrend = $this->get30DaysValuationTrend($totalAssetValue, $totalMarketValue);

        return [
            'total_items' => $totalItems,
            'total_asset_value' => $totalAssetValue,
            'total_market_value' => $totalMarketValue,
            'potential_profit' => $potentialProfit,
            'low_stock_count' => $lowStockCount,
            'out_of_stock_count' => $outOfStockCount,
            'today_mutations' => $todayMutations,
            'valuation_trend' => $valuationTrend,
        ];
    }

    // Compute day-by-day historical asset cost vs market selling valuation for the last 30 days
    public function get30DaysValuationTrend(float $currentAssetValue, float $currentMarketValue): array
    {
        $startDate = now()->subDays(29)->startOfDay();
        $mutations = StockMutation::with('product')
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $mutationsByDate = [];
        foreach ($mutations as $m) {
            $date = $m->created_at->format('Y-m-d');
            if (!isset($mutationsByDate[$date])) {
                $mutationsByDate[$date] = [];
            }
            $mutationsByDate[$date][] = $m;
        }

        $trend = [];
        $runningAssetValue = $currentAssetValue;
        $runningMarketValue = $currentMarketValue;

        for ($i = 0; $i < 30; $i++) {
            $dateObj = now()->subDays($i);
            $dateKey = $dateObj->format('Y-m-d');
            $dateLabel = $dateObj->translatedFormat('d M');

            $trend[] = [
                'date' => $dateKey,
                'label' => $dateLabel,
                'asset_value' => round(max(0, $runningAssetValue), 2),
                'market_value' => round(max(0, $runningMarketValue), 2),
            ];

            if (isset($mutationsByDate[$dateKey])) {
                foreach ($mutationsByDate[$dateKey] as $mutation) {
                    $purchasePrice = $mutation->product ? (float) $mutation->product->purchase_price : 0;
                    $sellingPrice = $mutation->product ? (float) $mutation->product->selling_price : 0;
                    $qty = (int) $mutation->quantity;

                    if ($mutation->type === 'in') {
                        $runningAssetValue -= ($qty * $purchasePrice);
                        $runningMarketValue -= ($qty * $sellingPrice);
                    } else if ($mutation->type === 'out') {
                        $runningAssetValue += ($qty * $purchasePrice);
                        $runningMarketValue += ($qty * $sellingPrice);
                    }
                }
            }
        }

        return array_reverse($trend);
    }
}
