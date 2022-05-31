<?php

namespace Dealskoo\Product\Models;

use Dealskoo\Admin\Traits\HasSlug;
use Dealskoo\Category\Traits\HasCategory;
use Dealskoo\Country\Traits\HasCountry;
use Dealskoo\Seller\Traits\HasSeller;
use Dealskoo\Brand\Traits\HasBrand;
use Dealskoo\Platform\Traits\HasPlatform;
use Dealskoo\Image\Traits\Imaginable;
use Dealskoo\Tag\Traits\Taggable;
use Dealskoo\Comment\Traits\Commentable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasSlug, HasCategory, HasCountry, HasSeller, HasBrand, HasPlatform, Imaginable, Taggable, Commentable, Searchable;

    protected $appends = [
        'cover', 'cover_url'
    ];

    protected $fillable = [
        'slug',
        'name',
        'url',
        'price',
        'clicks',
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
        'approved_at' => 'datetime'
    ];

    public function getCoverUrlAttribute()
    {
        return empty($this->cover) ? asset(config('product.default_cover')) : Storage::url($this->cover->filename);
    }

    public function scopeApproved(Builder $builder)
    {
        return $builder->whereNotNull('approved_at');
    }

    public function shouldBeSearchable()
    {
        return $this->approved_at ? true : false;
    }

    public function toSearchableArray()
    {
        return $this->only([
            'slug',
            'name',
            'url',
            'price',
            'clicks',
            'description',
            'score',
            'category_id',
            'country_id',
            'seller_id',
            'brand_id',
            'platform_id',
        ]);
    }
}
