<?php

namespace Dealskoo\Product\Http\Controllers\Seller;

use Dealskoo\Brand\Models\Brand;
use Dealskoo\Category\Models\Category;
use Dealskoo\Platform\Models\Platform;
use Dealskoo\Seller\Http\Controllers\Controller as SellerController;
use Dealskoo\Product\Models\Product;
use Dealskoo\Tag\Facades\TagManager;
use Dealskoo\Image\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $columns = ['id', 'name', 'price', 'clicks', 'category_id', 'country_id', 'brand_id', 'platform_id', 'approved_at', 'created_at', 'updated_at'];
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
            $row[] = Str::words($product->name, 5, '...');
            $row[] = $product->country->currency_symbol . $product->price;
            $row[] = $product->clicks;
            $row[] = $product->category->name;
            $row[] = $product->country->name;
            $row[] = $product->brand ? $product->brand->name : '';
            $row[] = $product->platform ? $product->platform->name : '';
            $row[] = $product->approved_at != null ? $product->approved_at->format('Y-m-d H:i:s') : null;
            $row[] = $product->created_at->format('Y-m-d H:i:s');
            $row[] = $product->updated_at->format('Y-m-d H:i:s');
            $upload_link = '';
            $edit_link = '';
            $destroy_link = '';
            if (!$product->approved_at) {
                $upload_link = '<a href="' . route('seller.products.images', $product) . '" class="action-icon"><i class="mdi mdi-file-image"></i></a>';
                $edit_link = '<a href="' . route('seller.products.edit', $product) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
                $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="products_table" data-url="' . route('seller.products.destroy', $product) . '"> <i class="mdi mdi-delete"></i></a>';
            }
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
        $categories = Category::where('country_id', $request->user()->country->id)->get();
        $brands = Brand::approved()->where('country_id', $request->user()->country->id)->get();
        $platforms = Platform::approved()->where('country_id', $request->user()->country->id)->get();
        return view('product::seller.product.create', ['categories' => $categories, 'brands' => $brands, 'platforms' => $platforms]);
    }

    public function store(Request $request)
    {
        $vals = [
            'name' => ['required', 'string'],
            'url' => ['required', 'url'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'exists:categories,id']
        ];
        if ($request->has(['brand_id', 'numberic'])) {
            $vals['brand_id'] = ['exists:brands,id'];
        }
        if ($request->has(['platform_id', 'numberic'])) {
            $vals['platform_id'] = ['exists:platforms,id'];
        }

        $request->validate($vals);
        $product = new Product($request->only([
            'name',
            'url',
            'price',
            'category_id',
            'brand_id',
            'platform_id',
            'description'
        ]));
        $seller = $request->user();
        $product->seller_id = $seller->id;
        $product->country_id = $seller->country_id;
        $product->save();
        $tags = $request->input('tags', []);
        TagManager::sync($product, $tags);
        return redirect(route('seller.products.images', $product));
    }

    public function edit(Request $request, $id)
    {
        $product = Product::where('seller_id', $request->user()->id)->findOrFail($id);
        $categories = Category::where('country_id', $request->user()->country->id)->get();
        $brands = Brand::approved()->where('country_id', $request->user()->country->id)->get();
        $platforms = Platform::approved()->where('country_id', $request->user()->country->id)->get();
        return view('product::seller.product.edit', ['product' => $product, 'categories' => $categories, 'brands' => $brands, 'platforms' => $platforms]);
    }

    public function update(Request $request, $id)
    {
        $vals = [
            'name' => ['required', 'string'],
            'url' => ['required', 'url'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'exists:categories,id']
        ];
        if ($request->has(['brand_id', 'numberic'])) {
            $vals['brand_id'] = ['exists:brands,id'];
        }
        if ($request->has(['platform_id', 'numberic'])) {
            $vals['platform_id'] = ['exists:platforms,id'];
        }

        $request->validate($vals);
        $product = Product::where('seller_id', $request->user()->id)->findOrFail($id);
        $product->fill($request->only([
            'name',
            'url',
            'price',
            'category_id',
            'brand_id',
            'platform_id',
            'description'
        ]));
        $product->approved_at = null;
        $product->save();
        $tags = $request->input('tags', []);
        TagManager::sync($product, $tags);
        return redirect(route('seller.products.images', $product));
    }

    public function destroy(Request $request, $id)
    {
        return ['status' => Product::where('seller_id', $request->user()->id)->where('id', $id)->delete()];
    }

    public function images(Request $request, $product_id)
    {
        $product = Product::where('seller_id', $request->user()->id)->findOrFail($product_id);
        return view('product::seller.product.images', ['product' => $product]);
    }

    public function upload(Request $request, $product_id)
    {
        $request->validate([
            'file' => ['required', 'image', 'max:1000']
        ]);
        $product = Product::where('seller_id', $request->user()->id)->findOrFail($product_id);
        $file = $request->file('file');
        $filename = $product->id . '_' . time() . '.' . $file->guessExtension();
        $path = $file->storeAs('product/images/' . date('Ymd'), $filename);
        $image = new Image(['filename' => $path]);
        $product->images()->save($image);
        $image->refresh();
        return $image;
    }

    public function remove(Request $request, $product_id, $image_id)
    {
        $product = Product::where('seller_id', $request->user()->id)->findOrFail($product_id);
        return ['status' => $product->images()->delete($image_id)];
    }
}
