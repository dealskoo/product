<?php

namespace Dealskoo\Product\Http\Controllers\Admin;

use Carbon\Carbon;
use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Admin\Rules\Slug;
use Dealskoo\Product\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('products.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('product::admin.product.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'name', 'price', 'score', 'clicks', 'category_id', 'country_id', 'seller_id', 'brand_id', 'platform_id', 'approved_at', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Product::query();
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('slug', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $products = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('products.show');
        $can_edit = $request->user()->canDo('products.edit');
        foreach ($products as $product) {
            $row = [];
            $row[] = $product->id;
            $row[] = Str::words($product->name, 5, '...');
            $row[] = $product->country->currency_symbol . $product->price;
            $row[] = $product->score;
            $row[] = $product->clicks;
            $row[] = $product->category->name;
            $row[] = $product->country->name;
            $row[] = $product->seller->name;
            $row[] = $product->brand ? $product->brand->name : __('Unknown');
            $row[] = $product->platform ? $product->platform->name : __('Unknown');
            $row[] = $product->approved_at != null ? Carbon::parse($product->approved_at)->format('Y-m-d H:i:s') : null;
            $row[] = Carbon::parse($product->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($product->updated_at)->format('Y-m-d H:i:s');
            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.products.show', $product) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.products.edit', $product) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $row[] = $view_link . $edit_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function show(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('products.show'), 403);
        $product = Product::query()->findOrFail($id);
        return view('product::admin.product.show', ['product' => $product]);
    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('products.edit'), 403);
        $product = Product::query()->findOrFail($id);
        return view('product::admin.product.edit', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('products.edit'), 403);
        $request->validate([
            'slug' => ['required', new Slug('products', 'slug', $id, 'id')],
            'score' => ['required', 'numeric', 'between:0,' . config('product.max_score')],
        ]);
        $product = Product::query()->findOrFail($id);
        $product->fill($request->only([
            'slug',
            'score'
        ]));
        $product->approved_at = $request->boolean('approved', false) ? Carbon::now() : null;
        $product->save();
        return back()->with('success', __('admin::admin.update_success'));
    }
}
