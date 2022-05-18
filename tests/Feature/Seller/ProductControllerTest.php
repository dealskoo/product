<?php

namespace Dealskoo\Product\Tests\Feature\Seller;

use Dealskoo\Image\Models\Image;
use Dealskoo\Country\Models\Country;
use Dealskoo\Product\Models\Product;
use Dealskoo\Product\Tests\TestCase;
use Dealskoo\Seller\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.products.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.products.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $country = Country::factory()->create(['alpha2' => 'US']);
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.products.create'));
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $seller = Seller::factory()->create();
        $product = Product::factory()->make();
        $response = $this->actingAs($seller, 'seller')->post(route('seller.products.store'), $product->only([
            'name',
            'url',
            'price',
            'category_id',
            'brand_id',
            'platform_id',
            'description'
        ]));
        $response->assertStatus(302);
    }

    public function test_edit()
    {
        $country = Country::factory()->create(['alpha2' => 'US']);
        $seller = Seller::factory()->create();
        $product = Product::factory()->create(['seller_id' => $seller->id, 'country_id' => $country->id]);
        $response = $this->actingAs($seller, 'seller')->get(route('seller.products.edit', $product));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $seller = Seller::factory()->create();
        $product = Product::factory()->create(['seller_id' => $seller->id]);
        $product1 = Product::factory()->make();
        $response = $this->actingAs($seller, 'seller')->put(route('seller.products.update', $product), $product1->only([
            'name',
            'url',
            'price',
            'category_id',
            'brand_id',
            'platform_id',
            'description'
        ]));
        $response->assertStatus(302);
    }

    public function test_destroy()
    {
        $seller = Seller::factory()->create();
        $product = Product::factory()->create(['seller_id' => $seller->id]);
        $response = $this->actingAs($seller, 'seller')->delete(route('seller.products.destroy', $product));
        $response->assertStatus(200);
    }

    public function test_images()
    {
        $seller = Seller::factory()->create();
        $product = Product::factory()->create(['seller_id' => $seller->id]);
        $response = $this->actingAs($seller, 'seller')->get(route('seller.products.images', $product));
        $response->assertStatus(200);
    }

    public function test_upload()
    {
        Storage::fake();
        $seller = Seller::factory()->create();
        $product = Product::factory()->create(['seller_id' => $seller->id]);
        $response = $this->actingAs($seller, 'seller')->post(route('seller.products.images.upload', $product), [
            'file' => UploadedFile::fake()->image('file.jpg')
        ]);
        $url = json_decode($response->content())->url;
        $filename = basename($url);
        Storage::assertExists('product/images/' . date('Ymd') . '/' . $filename);
    }

    public function test_remove()
    {
        $seller = Seller::factory()->create();
        $product = Product::factory()->create(['seller_id' => $seller->id]);
        $image = Image::factory()->make();
        $product->images()->save($image);
        $response = $this->actingAs($seller, 'seller')->get(route('seller.products.images.remove', [$product, $product->cover]));
        $response->assertStatus(200);
    }
}
