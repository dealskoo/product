<?php

namespace Dealskoo\Product\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Dealskoo\Seller\Facades\SellerMenu;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/product.php', 'product');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../config/product.php' => config_path('product.php')
            ], 'config');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/product')
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/seller.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'product');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'product');

        AdminMenu::route('admin.products.index', 'product::product.products', [], ['icon' => 'uil-briefcase', 'permission' => 'products.index'])->order(3);

        PermissionManager::add(new Permission('products.index', 'Product List'));
        PermissionManager::add(new Permission('products.show', 'View Product'), 'products.index');
        PermissionManager::add(new Permission('products.edit', 'Edit Product'), 'products.index');

        SellerMenu::route('seller.products.index', 'product::product.products', [], ['icon' => 'uil-briefcase me-1'])->order(4);
    }
}
