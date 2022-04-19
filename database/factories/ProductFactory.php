<?php

namespace Database\Factories\Dealskoo\Product\Models;

use Dealskoo\Brand\Models\Brand;
use Dealskoo\Category\Models\Category;
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
        $brand = Brand::factory()->create();

        return [
            'slug' => $this->faker->unique()->slug,
            'name' => $this->faker->title,
            'url' => $this->faker->url,
            'price' => $this->faker->numberBetween(0, 1000),
            'description' => $this->faker->text,
            'score' => $this->faker->numberBetween(0, 5),
            'category_id' => Category::factory()->create(['country_id' => $brand->country_id]),
            'country_id' => $brand->country_id,
            'seller_id' => $brand->seller_id,
            'brand_id' => $brand->id,
            'platform_id' => Platform::factory()->create(['country_id' => $brand->country_id, 'seller_id' => $brand->seller_id]),
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
