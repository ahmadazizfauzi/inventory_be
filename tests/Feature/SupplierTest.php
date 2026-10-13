<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    private function authenticateAs(string $role): string
    {
        $user = User::factory()->create(['role' => $role]);

        return JWTAuth::fromUser($user);
    }

    public function test_authenticated_user_can_list_suppliers(): void
    {
        Supplier::create(['name' => 'PT Distributor Utama', 'phone' => '021-123456']);
        $token = $this->authenticateAs('staff');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/suppliers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status_code',
                'data' => [
                    '*' => ['id', 'name', 'phone'],
                ],
            ]);
    }

    public function test_admin_can_create_supplier(): void
    {
        $token = $this->authenticateAs('admin');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/suppliers', [
                'name' => 'PT Metro Mandiri',
                'phone' => '021-888999',
                'email' => 'sales@metromandiri.co.id',
                'address' => 'Jakarta Barat',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'PT Metro Mandiri');

        $this->assertDatabaseHas('suppliers', ['name' => 'PT Metro Mandiri']);
    }

    public function test_staff_cannot_create_supplier(): void
    {
        $token = $this->authenticateAs('staff');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/suppliers', [
                'name' => 'PT Metro Mandiri',
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_supplier(): void
    {
        $supplier = Supplier::create(['name' => 'CV Supplier Lama', 'phone' => '021-111222']);
        $token = $this->authenticateAs('admin');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->putJson("/api/suppliers/{$supplier->id}", [
                'name' => 'CV Supplier Baru',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'CV Supplier Baru');
    }

    public function test_admin_can_delete_supplier(): void
    {
        $supplier = Supplier::create(['name' => 'Supplier To Delete']);
        $token = $this->authenticateAs('admin');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson("/api/suppliers/{$supplier->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('suppliers', ['id' => $supplier->id]);
    }

    public function test_cannot_create_supplier_without_name(): void
    {
        $token = $this->authenticateAs('admin');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/suppliers', [
                'phone' => '08123456789',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
