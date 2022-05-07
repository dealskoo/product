<?php

namespace Dealskoo\Product\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Product\Tests\TestCase;
use Dealskoo\Seller\Facades\SellerMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        $this->assertNotNull(AdminMenu::findBy('title', 'product::product.products'));
        $this->assertNotNull(SellerMenu::findBy('title', 'product::product.products'));
    }
}
