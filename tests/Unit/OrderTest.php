<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_order()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('orders.store'), [
            'shipping_address' => 'Test Address',
            'shipping_city' => 'Test City',
            'shipping_country' => 'FR'
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'shipping_address' => 'Test Address'
        ]);
    }

    public function test_order_belongs_to_user()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($user->id, $order->user->id);
    }

    public function test_order_has_correct_total()
    {
        $order = Order::factory()->create();
        $product1 = Product::factory()->create(['price' => 100]);
        $product2 = Product::factory()->create(['price' => 200]);

        $order->items()->create([
            'product_id' => $product1->id,
            'quantity' => 2,
            'price' => $product1->price
        ]);

        $order->items()->create([
            'product_id' => $product2->id,
            'quantity' => 1,
            'price' => $product2->price
        ]);

        $this->assertEquals(400, $order->total_amount);
    }
} 