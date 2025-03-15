<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->bothify('Code-####'),
            'oem_code' => $this->faker->bothify('OEM-####'),
            'name' => $this->faker->words(3, true),
            'product_type' => $this->faker->numberBetween(1, 2),
            'brand' => $this->faker->numberBetween(3, 4),
            'product_category' => $this->faker->numberBetween(5, 6),
            'car_brand' => $this->faker->numberBetween(7, 8),
            'car_model' => $this->faker->numberBetween(9, 12),
            'stock' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'discounted_price' => $this->faker->randomFloat(2, 10, 100),
            'image' => $this->faker->imageUrl(),
            'campaign' => $this->faker->boolean,
            'new_product' => $this->faker->boolean
        ];
    }
}
