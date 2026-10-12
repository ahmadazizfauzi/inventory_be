<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_fetch_dashboard_summary(): void
    {
        $category = Category::create(['name' => 'Elektronik']);
        Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-DASH-01',
            'name' => 'Barang A',
            'purchase_price' => 100000,
            'selling_price' => 150000,
            'stock' => 10,
            'min_stock' => 5,
        ]);

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/dashboard/summary');

        $response->assertStatus(200)
            ->assertJson([
                'status_code' => 200,
                'data' => [
                    'total_items' => 1,
                    'total_asset_value' => 1000000.0,
                    'total_market_value' => 1500000.0,
                    'potential_profit' => 500000.0,
                    'low_stock_count' => 0,
                    'out_of_stock_count' => 0,
                ],
            ]);
    }
}
