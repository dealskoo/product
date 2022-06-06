<?php

namespace Database\Factories\Dealskoo\Product\Models;

use Dealskoo\Brand\Models\Brand;
use Dealskoo\Category\Models\Category;
use Dealskoo\Platform\Models\Platform;
use Dealskoo\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->unique()->slug,
            'name' => $this->faker->title,
            'url' => $this->faker->url,
            'price' => $this->faker->numberBetween(0, 1000),
            'description' => $this->faker->text,
            'score' => $this->faker->numberBetween(0, 5),
            'brand_id' => Brand::factory(),
            'country_id' => function ($product) {
                return Brand::find($product['brand_id'])->country_id;
            },
            'seller_id' => function ($product) {
                return Brand::find($product['brand_id'])->seller_id;
            },
            'category_id' => function ($product) {
                return Category::factory()->create(['country_id' => $product['country_id']]);
            },
            'platform_id' => function ($product) {
                return Platform::factory()->create(['country_id' => $product['country_id'], 'seller_id' => $product['seller_id']]);
            },
        ];
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'approved_at' => $this->faker->dateTime,
            ];
        });
    }
}
