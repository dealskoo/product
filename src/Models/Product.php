<?php

namespace Dealskoo\Product\Models;

use Dealskoo\Admin\Traits\HasSlug;
use Dealskoo\Category\Traits\HasCategory;
use Dealskoo\Country\Traits\HasCountry;
use Dealskoo\Seller\Traits\HasSeller;
use Dealskoo\Brand\Traits\HasBrand;
use Dealskoo\Platform\Traits\HasPlatform;
use Dealskoo\Image\Traits\Imageable;
use Dealskoo\Tag\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasSlug, HasCategory, HasCountry, HasSeller, HasBrand, HasPlatform, Imageable, Taggable;

    protected $appends = [
        'cover_url'
    ];

    protected $fillable = [
        'slug',
        'name',
        'url',
        'price',
        'description',
        'score',
        'category_id',
        'country_id',
        'seller_id',
        'brand_id',
        'platform_id',
        'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datatime'
    ];

    public function getCoverUrlAttribute()
    {
        return '';
    }
}
