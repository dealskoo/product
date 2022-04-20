<?php

namespace Dealskoo\Product\Http\Controllers\Seller;

use Dealskoo\Brand\Models\Brand;
use Dealskoo\Category\Models\Category;
use Dealskoo\Platform\Models\Platform;
use Dealskoo\Seller\Http\Controllers\Controller as SellerController;
use Dealskoo\Product\Models\Product;
use Illuminate\Http\Request;

class ProductController extends SellerController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('product::seller.product.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'name', 'price', 'category_id', 'country_id', 'brand_id', 'platform_id', 'approved_at', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Product::where('seller_id', $request->user()->id);
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('slug', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $products = $query->skip($start)->take($limit)->get();
        $rows = [];
        foreach ($products as $product) {
            $row = [];
            $row[] = $product->id;
            $row[] = $product->name;
            $row[] = $product->price;
            $row[] = $product->category->name;
            $row[] = $product->country->name;
            $row[] = $product->brand->name;
            $row[] = $product->platform->name;
            $row[] = $product->approved_at != null ? Carbon::parse($product->approved_at)->format('Y-m-d H:i:s') : null;
            $row[] = Carbon::parse($product->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($product->updated_at)->format('Y-m-d H:i:s');
            $upload_link = '<a href="' . route('seller.products.images', $product) . '" class="action-icon"><i class="mdi mdi-file-image"></i></a>';
            $edit_link = '<a href="' . route('seller.products.edit', $product) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="products_table" data-url="' . route('seller.products.destroy', $product) . '"> <i class="mdi mdi-delete"></i></a>';
            $row[] = $upload_link . $edit_link . $destroy_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function create(Request $request)
    {
        $categories = Category::where('country_id', $request->country()->id)->get();
        $brands = Brand::where('country_id', $request->country()->id)->get();
        $platforms = Platform::where('country_id', $request->country()->id)->get();
        return view('product::seller.product.create', ['categories' => $categories, 'brands' => $brands, 'platforms' => $platforms]);
    }

    public function store(Request $request)
    {

    }

    public function edit(Request $request, $id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function images(Request $request, $product_id)
    {

    }

    public function upload(Request $request, $product_id)
    {

    }

    public function remove(Request $request, $product_id, $image_id)
    {

    }
}
