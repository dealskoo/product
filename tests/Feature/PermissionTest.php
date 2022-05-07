<?php

namespace Dealskoo\Product\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Product\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        $this->assertNotNull(PermissionManager::getPermission('products.index'));
        $this->assertNotNull(PermissionManager::getPermission('products.show'));
        $this->assertNotNull(PermissionManager::getPermission('products.edit'));
    }
}
