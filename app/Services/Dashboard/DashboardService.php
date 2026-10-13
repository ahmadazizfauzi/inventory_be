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

    // Compute day-by-day historical asset cost vs market selling valuation adapting to real data range
    public function get30DaysValuationTrend(float $currentAssetValue, float $currentMarketValue): array
    {
        $earliestProductDate = Product::min('created_at');
        $earliestMutationDate = StockMutation::min('created_at');

        $earliest = null;
        if ($earliestProductDate && $earliestMutationDate) {
            $earliest = min($earliestProductDate, $earliestMutationDate);
        } elseif ($earliestProductDate) {
            $earliest = $earliestProductDate;
        } elseif ($earliestMutationDate) {
            $earliest = $earliestMutationDate;
        }

        if (!$earliest || ($currentAssetValue <= 0 && $currentMarketValue <= 0)) {
            return [];
        }

        $earliestDateObj = \Carbon\Carbon::parse($earliest)->startOfDay();
        $today = now()->startOfDay();

        // Calculate actual active days count between earliest date and today (max 30 days)
        $diffDays = (int) $today->diffInDays($earliestDateObj);
        $daysCount = min(30, max(1, $diffDays + 1));

        $startDate = now()->subDays($daysCount - 1)->startOfDay();
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

        for ($i = 0; $i < $daysCount; $i++) {
            $dateObj = now()->subDays($i);
            $dateKey = $dateObj->format('Y-m-d');
            $dateLabel = $dateObj->translatedFormat('d M');

            $isBeforeEarliest = $dateObj->lt($earliestDateObj);

            $trend[] = [
                'date' => $dateKey,
                'label' => $dateLabel,
                'asset_value' => $isBeforeEarliest ? 0 : round(max(0, $runningAssetValue), 2),
                'market_value' => $isBeforeEarliest ? 0 : round(max(0, $runningMarketValue), 2),
                'has_data' => !$isBeforeEarliest,
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

        // If data only spans 1 day, prepend previous day as 0 baseline
        // so user sees the rise to the active point with prominent circle
        if ($daysCount === 1) {
            $prevDay = now()->subDay();
            $trend[] = [
                'date' => $prevDay->format('Y-m-d'),
                'label' => $prevDay->translatedFormat('d M'),
                'asset_value' => 0,
                'market_value' => 0,
                'has_data' => false,
            ];
        }

        return array_reverse($trend);
    }
}
