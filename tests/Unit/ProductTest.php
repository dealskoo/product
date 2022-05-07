<?php

namespace Dealskoo\Product\Tests\Unit;

use Dealskoo\Image\Models\Image;
use Dealskoo\Product\Models\Product;
use Dealskoo\Product\Tests\TestCase;
use Dealskoo\Tag\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_cover()
    {
        $image = Image::factory()->make();
        $product = Product::factory()->create();
        $product->images()->save($image);
        $this->assertCount(1, $product->images);
        $this->assertNotNull($product->cover);
    }

    public function test_slug()
    {
        $slug = 'Product';
        $product = Product::factory()->create();
        $product->slug = $slug;
        $product->save();
        $product->refresh();
        $this->assertEquals($product->slug, Str::lower($slug));
    }

    public function test_country()
    {
        $product = Product::factory()->create();
        $this->assertNotNull($product->country);
    }

    public function test_category()
    {
        $product = Product::factory()->create();
        $this->assertNotNull($product->category);
    }

    public function test_seller()
    {
        $product = Product::factory()->create();
        $this->assertNotNull($product->seller);
    }

    public function test_brand()
    {
        $product = Product::factory()->create();
        $this->assertNotNull($product->brand);
    }

    public function test_platform()
    {
        $product = Product::factory()->create();
        $this->assertNotNull($product->platform);
    }

    public function test_tag()
    {
        $tag = Tag::factory()->create();
        $product = Product::factory()->create();
        $product->tag($tag);
        $this->assertCount(1, $product->tags);
    }

    public function test_with_approved()
    {
        $count = 2;
        Product::factory()->create();
        Product::factory()->count($count)->approved()->create();
        $this->assertEquals($count, Product::approved()->count());
    }
}
