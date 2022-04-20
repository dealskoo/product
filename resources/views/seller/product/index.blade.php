@extends('seller::layouts.panel')

@section('title',__('product::product.products_list'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.dashboard') }}">{{ __('seller::seller.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('product::product.products_list') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('product::product.products_list') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a href="{{ route('seller.products.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle me-2"></i> {{ __('product::product.add_product') }}
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="products_table" class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('product::product.id') }}</th>
                                <th>{{ __('product::product.name') }}</th>
                                <th>{{ __('product::product.price') }}</th>
                                <th>{{ __('product::product.category') }}</th>
                                <th>{{ __('product::product.country') }}</th>
                                <th>{{ __('product::product.brand') }}</th>
                                <th>{{ __('product::product.platform') }}</th>
                                <th>{{ __('product::product.approved_at') }}</th>
                                <th>{{ __('product::product.created_at') }}</th>
                                <th>{{ __('product::product.updated_at') }}</th>
                                <th>{{ __('product::product.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            let table = $('#products_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('seller.products.index') }}",
                "language": language,
                "pageLength": pageLength,
                "columns": [
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': false},
                ],
                "order": [[0, "desc"]],
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    $('#products_table tr td:nth-child(11)').addClass('table-action');
                    delete_listener();
                }
            });
            table.on('childRow.dt', function (e, row) {
                delete_listener();
            });
        });
    </script>
@endsection
