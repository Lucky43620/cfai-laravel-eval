<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    private $categories = [
        'electronics' => [300, 400, 500, 600, 700],
        'clothing' => [800, 900, 1000, 1100, 1200],
        'books' => [200, 201, 202, 203, 204],
        'home' => [100, 101, 102, 103, 104],
        'sports' => [150, 151, 152, 153, 154],
        'food' => [250, 251, 252, 253, 254],
        'toys' => [350, 351, 352, 353, 354],
        'beauty' => [450, 451, 452, 453, 454],
        'garden' => [550, 551, 552, 553, 554],
        'art' => [650, 651, 652, 653, 654]
    ];

    public function definition()
    {
        $name = $this->faker->unique()->words(3, true);
        $category = $this->faker->randomElement(array_keys($this->categories));
        $imageId = $this->faker->randomElement($this->categories[$category]);

        // Utilise Lorem Picsum avec une ID fixe pour avoir la même image à chaque fois
        $imageUrl = "https://picsum.photos/id/{$imageId}/800/600";

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'category_id' => Category::factory(),
            'image' => $imageUrl,
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
