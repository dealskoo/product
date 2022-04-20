<?php

namespace Dealskoo\Product\Tests;

use Dealskoo\Product\Providers\ProductServiceProvider;

abstract class TestCase extends \Dealskoo\Seller\Tests\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ProductServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [];
    }
}

