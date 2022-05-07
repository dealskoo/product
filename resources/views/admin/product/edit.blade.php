@extends('admin::layouts.panel')

@section('title',__('product::product.edit_product'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
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
                    <form action="{{ route('admin.products.update',$product) }}" method="post">
                        @csrf
                        @method('PUT')
                        @if(!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if(!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name"
                                               class="form-label">{{ __('product::product.name') }}</label>
                                        <input type="text" class="form-control" readonly
                                               value="{{ $product->name }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="slug"
                                               class="form-label">{{ __('product::product.slug') }}</label>
                                        <input type="text" class="form-control" id="slug" name="slug" required
                                               value="{{ old('slug',$product->slug) }}" tabindex="1" autofocus
                                               placeholder="{{ __('product::product.slug_placeholder') }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="url"
                                               class="form-label">{{ __('product::product.url') }}</label>
                                        <input type="url" class="form-control" readonly
                                               value="{{ $product->url }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="price"
                                               class="form-label">{{ __('product::product.price') }}</label>
                                        <input type="number" class="form-control" readonly
                                               value="{{ $product->price }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="approved"
                                                   name="approved" tabindex="2" value="1"
                                                   @if(old('approved') || $product->approved_at !=null) checked @endif>
                                            <label for="approved"
                                                   class="form-check-label">{{ __('product::product.approved') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="website"
                                               class="form-label">{{ __('product::product.tag') }}</label>
                                        <div class="mt-1 tags-box">
                                            @unless(empty($product->tags))
                                                @foreach($product->tags as $tag)
                                                    <div
                                                        class="badge bg-primary rounded-pill position-relative me-2 mt-2 tag-badge">
                                                        {{ $tag->name }}<input type="hidden"
                                                                               name="tags[]"
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
                                               value="{{ $product->brand?$product->brand->name:__('unknown') }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="website"
                                               class="form-label">{{ __('product::product.platform') }}</label>
                                        <input type="text" class="form-control" readonly
                                               value="{{ $product->platform?$product->platform->name:__('unknown')}}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="description"
                                               class="form-label">{{ __('product::product.description') }}</label>
                                        <textarea class="form-control" name="description" id="description" rows="5"
                                                  readonly>{{ old('description',$product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row mt-2">
                            @foreach($product->images as $image)
                                <div class="col-md-2">
                                    <img src="{{ $image->url }}" class="img-fluid">
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit" class="btn btn-success mt-2" tabindex="3"><i
                                        class="mdi mdi-content-save"></i> {{ __('admin::admin.save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
