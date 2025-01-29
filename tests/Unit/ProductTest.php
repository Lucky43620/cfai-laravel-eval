<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product()
    {
        $category = Category::factory()->create();
        
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 10
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99
        ]);
    }

    public function test_product_has_correct_average_rating()
    {
        $product = Product::factory()->create();
        
        Review::factory()->count(3)->create([
            'product_id' => $product->id,
            'rating' => 4
        ]);

        $this->assertEquals(4, $product->getAverageRatingAttribute());
    }

    public function test_product_belongs_to_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    public function test_can_update_product_stock()
    {
        $product = Product::factory()->create(['stock' => 10]);
        
        $product->update(['stock' => 5]);
        
        $this->assertEquals(5, $product->fresh()->stock);
    }
} 