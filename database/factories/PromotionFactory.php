<?php

namespace Database\Factories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['buy_x_get_y', 'fixed_price', 'discount_percentage']);
        $discountPercentage = $type === 'discount_percentage' ? $this->faker->numberBetween(1, 100) : null;
        $buyQuantity = $type === 'buy_x_get_y' ? $this->faker->numberBetween(1, 5) : null;
        $getQuantity = $type === 'buy_x_get_y' ? $this->faker->numberBetween($buyQuantity + 1, $buyQuantity + 5) : null;
        $fixedPrice = $type === 'fixed_price' ? $this->faker->randomFloat(2, 1, 100) : null;
    
        return [
            'code' => $this->faker->unique()->word,
            'type' => $type,
            'discount_percentage' => $discountPercentage,
            'buy_quantity' => $buyQuantity,
            'get_quantity' => $getQuantity,
            'fixed_price' => $fixedPrice,
            'valid_from' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'valid_until' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}