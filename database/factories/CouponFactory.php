<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['fixed', 'percentage']);
        $value = $type === 'fixed' 
            ? $this->faker->numberBetween(5, 50) 
            : $this->faker->numberBetween(5, 30);

        return [
            'code' => strtoupper(Str::random(8)),
            'type' => $type,
            'value' => $value,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(3),
            'max_uses' => $this->faker->optional()->numberBetween(10, 100),
            'times_used' => 0,
        ];
    }
} 