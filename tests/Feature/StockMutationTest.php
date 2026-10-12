<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class StockMutationTest extends TestCase
{
    use RefreshDatabase;

    private function createProductWithStock(int $initialStock = 10): Product
    {
        $category = Category::create(['name' => 'Elektronik']);

        return Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-TEST-01',
            'name' => 'Barang Uji',
            'purchase_price' => 100000,
            'selling_price' => 150000,
            'stock' => $initialStock,
            'min_stock' => 5,
        ]);
    }

    public function test_stock_in_increases_product_stock_automatically(): void
    {
        $product = $this->createProductWithStock(5);
        $supplier = Supplier::create(['name' => 'Supplier Utama']);
        $user = User::factory()->create(['role' => 'staff']);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/stock-mutations', [
                'product_id' => $product->id,
                'supplier_id' => $supplier->id,
                'type' => 'in',
                'quantity' => 10,
                'notes' => 'Restock barang',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.stock_before', 5)
            ->assertJsonPath('data.stock_after', 15);

        $this->assertEquals(15, $product->fresh()->stock);
    }

    public function test_stock_out_decreases_product_stock_automatically(): void
    {
        $product = $this->createProductWithStock(10);
        $user = User::factory()->create(['role' => 'staff']);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/stock-mutations', [
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => 4,
                'notes' => 'Barang keluar',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.stock_before', 10)
            ->assertJsonPath('data.stock_after', 6);

        $this->assertEquals(6, $product->fresh()->stock);
    }

    public function test_stock_out_fails_if_quantity_exceeds_available_stock(): void
    {
        $product = $this->createProductWithStock(5);
        $user = User::factory()->create(['role' => 'staff']);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/stock-mutations', [
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => 50,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['quantity']);

        $this->assertEquals(5, $product->fresh()->stock);
    }

    public function test_can_list_stock_mutations_history(): void
    {
        $product = $this->createProductWithStock(10);
        $user = User::factory()->create(['role' => 'staff']);
        $token = JWTAuth::fromUser($user);

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/stock-mutations', [
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => 5,
            ]);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/stock-mutations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status_code',
                'data' => [
                    '*' => ['id', 'product_id', 'type', 'quantity', 'stock_before', 'stock_after'],
                ],
                'pagination',
            ]);
    }
}
