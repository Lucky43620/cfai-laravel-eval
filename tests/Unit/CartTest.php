<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_product_to_cart()
    {
        $product = Product::factory()->create();
        
        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $cart = session()->get('cart');
        
        $this->assertArrayHasKey($product->id, $cart);
        $this->assertEquals(1, $cart[$product->id]['quantity']);
    }

    public function test_can_update_cart_quantity()
    {
        $product = Product::factory()->create();
        
        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $response = $this->patch(route('cart.update'), [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $cart = session()->get('cart');
        $this->assertEquals(2, $cart[$product->id]['quantity']);
    }

    public function test_can_remove_product_from_cart()
    {
        $product = Product::factory()->create();
        
        $this->post(route('cart.add'), [
            'product_id' => $product->id
        ]);

        $response = $this->delete(route('cart.remove', $product->id));

        $cart = session()->get('cart');
        $this->assertArrayNotHasKey($product->id, $cart);
    }
} 