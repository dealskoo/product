@extends('seller::layouts.panel')
@section('title', __('product::product.edit_product'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.products.index') }}">{{ __('product::product.products_list') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('product::product.edit_product') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('product::product.edit_product') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('seller.products.update', $product) }}" method="post">
                        @csrf
                        @method('PUT')
                        @if (!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if (!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">{{ __('product::product.name') }}</label>
                                        <input type="text" class="form-control" id="name" name="name" required
                                            value="{{ old('name', $product->name) }}" autofocus tabindex="1"
                                            placeholder="{{ __('product::product.name_placeholder') }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="url" class="form-label">{{ __('product::product.url') }}</label>
                                        <input type="url" class="form-control" id="url" name="url" required
                                            value="{{ old('url', $product->url) }}" tabindex="3"
                                            placeholder="{{ __('product::product.url_placeholder') }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="price"
                                            class="form-label">{{ __('product::product.price') }}</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">{!! request()->country()->currency_symbol !!}</span>
                                            <input type="number" class="form-control" id="price" name="price" required
                                                value="{{ old('price', $product->price) }}" tabindex="5"
                                                placeholder="{{ __('product::product.price_placeholder') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="website"
                                            class="form-label">{{ __('product::product.tag') }}</label>
                                        <input type="text" class="form-control tag-input" id="tag" name="tag"
                                            value="{{ old('tag') }}" tabindex="7"
                                            placeholder="{{ __('product::product.tag_placeholder') }}">
                                        <div class="mt-1 tags-box">
                                            @unless(empty(old('tags')))
                                                @foreach (old('tags') as $tag)
                                                    <div
                                                        class="badge bg-primary rounded-pill position-relative me-2 mt-2 tag-badge">
                                                        {{ $tag }}<input type="hidden" name="tags[]"
                                                            value="{{ $tag }}"><span
                                                            class="position-absolute top-0 start-100 translate-middle bg-danger border border-light rounded-circle mdi mdi-close tag-remove"></span>
                                                    </div>
                                                @endforeach
                                            @else
                                                @unless(empty($product->tags))
                                                    @foreach ($product->tags as $tag)
                                                        <div
                                                            class="badge bg-primary rounded-pill position-relative me-2 mt-2 tag-badge">
                                                            {{ $tag->name }}<input type="hidden" name="tags[]"
                                                                value="{{ $tag->name }}"><span
                                                                class="position-absolute top-0 start-100 translate-middle bg-danger border border-light rounded-circle mdi mdi-close tag-remove"></span>
                                                        </div>
                                                    @endforeach
                                                @endunless
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
                                        <select id="category_id" name="category_id" class="form-control select2"
                                            data-toggle="select2" tabindex="5">
                                            @foreach ($categories as $category)
                                                @if (old('category_id', $product->category_id) == $category->id)
                                                    <option value="{{ $category->id }}" selected>{{ $category->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="website"
                                            class="form-label">{{ __('product::product.brand') }}</label>
                                        <select id="brand_id" name="brand_id" class="form-control select2"
                                            data-toggle="select2" tabindex="5">
                                            <option value="">{{ __('Unknown') }}</option>
                                            @foreach ($brands as $brand)
                                                @if (old('brand_id', $product->brand_id) == $brand->id)
                                                    <option value="{{ $brand->id }}" selected>{{ $brand->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="website"
                                            class="form-label">{{ __('product::product.platform') }}</label>
                                        <select id="platform_id" name="platform_id" class="form-control select2"
                                            data-toggle="select2" tabindex="5">
                                            <option value="">{{ __('Unknown') }}</option>
                                            @foreach ($platforms as $platform)
                                                @if (old('platform_id', $product->platform_id) == $platform->id)
                                                    <option value="{{ $platform->id }}" selected>{{ $platform->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="description"
                                            class="form-label">{{ __('product::product.description') }}</label>
                                        <textarea class="form-control" name="description" id="description" tabindex="8" rows="5"
                                            placeholder="{{ __('product::product.description_placeholder') }}">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="9"><i
                                    class="mdi mdi-content-save"></i> {{ __('product::product.next') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
