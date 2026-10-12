<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private function authenticateAs(string $role): string
    {
        $user = User::factory()->create(['role' => $role]);

        return JWTAuth::fromUser($user);
    }

    public function test_authenticated_user_can_list_products_with_pagination(): void
    {
        $category = Category::create(['name' => 'Elektronik']);
        Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-001',
            'name' => 'Monitor LG 24',
            'purchase_price' => 1000000,
            'selling_price' => 1300000,
            'stock' => 10,
            'min_stock' => 5,
        ]);

        $token = $this->authenticateAs('staff');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/products?page=1&per_page=10');

        $response->assertStatus(200)
            ->assertJson([
                'status_code' => 200,
            ])
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    '*' => ['id', 'sku', 'name', 'stock', 'stock_status'],
                ],
                'pagination' => [
                    'current_page',
                    'per_page',
                    'total',
                    'total_pages',
                    'has_next_page',
                    'has_prev_page',
                ],
            ]);
    }

    public function test_can_filter_products_by_search_keyword(): void
    {
        $category = Category::create(['name' => 'Elektronik']);
        Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-001',
            'name' => 'Monitor LG 24',
            'purchase_price' => 1000000,
            'selling_price' => 1300000,
            'stock' => 10,
            'min_stock' => 5,
        ]);

        Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-002',
            'name' => 'Mouse Logitech',
            'purchase_price' => 100000,
            'selling_price' => 150000,
            'stock' => 20,
            'min_stock' => 5,
        ]);

        $token = $this->authenticateAs('staff');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/products?search=Monitor');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.sku', 'PRD-001');
    }

    public function test_admin_can_create_product(): void
    {
        $category = Category::create(['name' => 'Jaringan']);
        $token = $this->authenticateAs('admin');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/products', [
                'category_id' => $category->id,
                'sku' => 'PRD-010',
                'name' => 'Router MikroTik',
                'purchase_price' => 750000,
                'selling_price' => 950000,
                'stock' => 5,
                'min_stock' => 2,
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'status_code' => 201,
                'data' => [
                    'sku' => 'PRD-010',
                    'name' => 'Router MikroTik',
                ],
            ]);

        $this->assertDatabaseHas('products', ['sku' => 'PRD-010']);
    }

    public function test_staff_cannot_create_product(): void
    {
        $category = Category::create(['name' => 'Jaringan']);
        $token = $this->authenticateAs('staff');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/products', [
                'category_id' => $category->id,
                'sku' => 'PRD-011',
                'name' => 'Switch Hub',
                'purchase_price' => 300000,
                'selling_price' => 400000,
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_product(): void
    {
        $category = Category::create(['name' => 'Display']);
        $product = Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-099',
            'name' => 'Monitor Old',
            'purchase_price' => 1000000,
            'selling_price' => 1200000,
            'stock' => 4,
            'min_stock' => 2,
        ]);

        $token = $this->authenticateAs('admin');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->putJson("/api/products/{$product->id}", [
                'name' => 'Monitor New Updated',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Monitor New Updated');
    }

    public function test_admin_can_soft_delete_product(): void
    {
        $category = Category::create(['name' => 'Display']);
        $product = Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-099',
            'name' => 'Monitor To Delete',
            'purchase_price' => 1000000,
            'selling_price' => 1200000,
            'stock' => 4,
            'min_stock' => 2,
        ]);

        $token = $this->authenticateAs('admin');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
