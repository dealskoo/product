<?php

namespace Dealskoo\Product\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Dealskoo\Product\Models\Product;
use Dealskoo\Product\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.products.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.products.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $product = Product::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.products.show', $product));
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $product = Product::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.products.edit', $product));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $product = Product::factory()->create();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.products.update', $product), [
            'slug' => 'product',
            'approved' => true
        ]);
        $response->assertStatus(302);
    }
}
