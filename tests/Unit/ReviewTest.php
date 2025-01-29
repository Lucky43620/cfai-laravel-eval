<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_review()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('reviews.store', $product), [
            'rating' => 5,
            'comment' => 'Great product!'
        ]);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Great product!'
        ]);
    }

    public function test_review_belongs_to_user_and_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        
        $review = Review::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        $this->assertInstanceOf(User::class, $review->user);
        $this->assertInstanceOf(Product::class, $review->product);
    }
} 