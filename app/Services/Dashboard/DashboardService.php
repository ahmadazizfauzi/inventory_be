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

        return [
            'total_items' => $totalItems,
            'total_asset_value' => $totalAssetValue,
            'total_market_value' => $totalMarketValue,
            'potential_profit' => $potentialProfit,
            'low_stock_count' => $lowStockCount,
            'out_of_stock_count' => $outOfStockCount,
            'today_mutations' => $todayMutations,
        ];
    }
}
