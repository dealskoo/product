@extends('admin::layouts.panel')

@section('title', __('product::product.view_product'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('product::product.view_product') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('product::product.view_product') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label">{{ __('product::product.name') }}</label>
                                    <input type="text" class="form-control" readonly value="{{ $product->name }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="slug" class="form-label">{{ __('product::product.slug') }}</label>
                                    <input type="text" class="form-control" readonly value="{{ $product->slug }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="url" class="form-label">{{ __('product::product.url') }}</label>
                                    <input type="url" class="form-control" readonly value="{{ $product->url }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="price" class="form-label">{{ __('product::product.price') }}</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">{!! request()->country()->currency_symbol !!}</span>
                                        <input type="number" class="form-control" readonly
                                            value="{{ $product->price }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="name"
                                        class="form-label">{{ __('product::product.approved_at') }}</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $product->approved_at }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="website" class="form-label">{{ __('product::product.tag') }}</label>
                                    <div class="mt-1 tags-box">
                                        @unless(empty($product->tags))
                                            @foreach ($product->tags as $tag)
                                                <div
                                                    class="badge bg-primary rounded-pill position-relative me-2 mt-2 tag-badge">
                                                    {{ $tag->name }}<input type="hidden" name="tags[]"
                                                        value="{{ $tag->name }}">
                                                </div>
                                            @endforeach
                                        @endunless
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="website"
                                        class="form-label">{{ __('product::product.category') }}</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $product->category->name }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="website"
                                        class="form-label">{{ __('product::product.brand') }}</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $product->brand ? $product->brand->name : __('Unknown') }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="website"
                                        class="form-label">{{ __('product::product.platform') }}</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $product->platform ? $product->platform->name : __('Unknown') }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="description"
                                        class="form-label">{{ __('product::product.description') }}</label>
                                    <textarea class="form-control" name="description" id="description" rows="5"
                                        readonly>{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row mt-2">
                        @foreach ($product->images as $image)
                            <div class="col-md-2">
                                <img src="{{ $image->url }}" class="img-fluid">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
