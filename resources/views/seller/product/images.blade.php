@extends('seller::layouts.panel')
@section('title', __('product::product.upload_images'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.products.index') }}">{{ __('product::product.products_list') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('product::product.upload_images') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('product::product.upload_images') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="upload-previews">
                        <input class="image-file" accept="image/*" type="file" style="display: none"/>
                        <div class="upload-zone" data-action="{{ route('seller.products.images.upload', $product) }}"
                             data-remove-action="{{ route('seller.products.images.remove', [$product, 'id']) }}">
                            <i class="h1 text-muted uil-cloud-upload"></i>
                            <p class="text-muted font-13">{{ __('product::product.click_to_upload') }}</p>
                        </div>
                        @foreach($product->images as $image)
                            <div class="upload-preview-image">
                                <img src="{{ $image->url }}" class="img-fluid"/>
                                <a href="javascript:void(0);" class="remove-image" data-id="{{ $image->id }}"><i
                                        class="uil-times"></i></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('/vendor/seller/js/ui/component.imageupload.js') }}"></script>
@endsection
