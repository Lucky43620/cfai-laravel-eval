<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_products()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Sanctum::actingAs($admin);

        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/admin/products');

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
    }

    public function test_can_create_product()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Sanctum::actingAs($admin);

        $productData = [
            'name' => 'New Product',
            'price' => 99.99,
            'description' => 'Test description',
            'category_id' => Category::factory()->create()->id
        ];

        $response = $this->postJson('/api/admin/products', $productData);

        $response->assertStatus(201)
                ->assertJsonFragment(['name' => 'New Product']);
    }

    public function test_non_admin_cannot_create_product()
    {
        $user = User::factory()->create(['is_admin' => false]);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/admin/products', []);

        $response->assertStatus(403);
    }
} 