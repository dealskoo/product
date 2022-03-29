<?php

namespace Dealskoo\Product\Traits;

use Dealskoo\Product\Models\Product;

trait HasProduct
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
