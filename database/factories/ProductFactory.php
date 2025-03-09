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
            'code' => $this->faker->bothify('Code-####'), // Rastgele kod
            'oem_code' => $this->faker->bothify('OEM-####'), // Rastgele OEM kodu
            'name' => $this->faker->words(3, true), // Rastgele ürün ismi
            'product_type' => $this->faker->numberBetween(1, 2), // Rastgele ürün tipi
            'brand' => $this->faker->numberBetween(3, 4), // Rastgele marka
            'product_category' => $this->faker->numberBetween(5, 6), // Rastgele kategori
            'car_brand' => $this->faker->numberBetween(7, 8), // Rastgele araba markası
            'car_model' => $this->faker->numberBetween(9, 12), // Rastgele araba modeli
            'stock' => $this->faker->numberBetween(0, 100), // Stok miktarı
            'price' => $this->faker->randomFloat(2, 10, 1000), // Fiyat
            'discounted_price' => $this->faker->randomFloat(2, 10, 1000), // İndirimli fiyat
            'image' => $this->faker->imageUrl(), // Rastgele resim URL'si
            'campaign' => $this->faker->boolean, // Kampanya durumu
            'new_product' => $this->faker->boolean // Yeni ürün durumu
        ];
    }
}
