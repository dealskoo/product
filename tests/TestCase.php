<?php

namespace Dealskoo\Product\Tests;

use Dealskoo\Product\Providers\ProductServiceProvider;

abstract class TestCase extends \Dealskoo\Billing\Tests\TestCase
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

