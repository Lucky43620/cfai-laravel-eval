<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Créer un admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Créer des utilisateurs réguliers
        User::factory(50)->create();

        // Créer des catégories
        Category::factory(10)->create()->each(function ($category) {
            // Créer des produits pour chaque catégorie
            Product::factory(rand(5, 15))->create([
                'category_id' => $category->id,
            ])->each(function ($product) {
                // Créer des avis pour chaque produit
                Review::factory(rand(0, 10))->create([
                    'product_id' => $product->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                ]);
            });
        });

        // Créer des coupons
        Coupon::factory(20)->create();

        // Créer des commandes
        User::all()->each(function ($user) {
            Order::factory(rand(0, 5))->create([
                'user_id' => $user->id,
            ])->each(function ($order) {
                // Créer des éléments de commande
                $products = Product::inRandomOrder()->take(rand(1, 5))->get();
                
                foreach ($products as $product) {
                    $quantity = rand(1, 3);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                }

                // Mettre à jour le montant total de la commande
                $order->update([
                    'total_amount' => $order->items->sum(function ($item) {
                        return $item->price * $item->quantity;
                    })
                ]);
            });
        });
    }
}
