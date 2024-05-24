@extends('layouts.app')

@push('before-css')
    <link href="{{asset('plugins/components/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
    <style>
        section.product-info ul {
            list-style: none;
            display: flex;
            padding: 10px 30px;
            gap: 10px;
        }
        
        section.product-info ul li input {
            width: 500px;
        }
    </style>
@endpush

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Product</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                    <li class="breadcrumb-item active">Product</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
            <a class="btn btn-info mb-1" href="{{ url('admin/product/create') }}">Add Product</a>
        </div>
    </div>
</div>

<section class="product-info">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="GET" action="{{ route('product.index') }}">
                    <ul>
                        <li>
                            <input type="text" class="form-control" name='search' placeholder="Search Product" value="{{ Request::get('search') }}">
                        </li>
                        <li>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="configuration">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product Info</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        <div class="">
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Title</th>
                                        <th>Product Price</th>
                                        <th>Product Sku</th>
                                        <th>Product Category</th>
                                        <th>Product Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td class="text-dark weight-600"> {{ \Illuminate\Support\Str::limit($item->product_title, 150, $end='...') }} </td>
                                        <td>${{ $item->list_price }}</td>
                                        <td> {{ $item->sku }}</td>
                                        <td>{{ $item->categorys->name }}</td>
                                        <td><img src="{{asset($item->image)}}" alt="" title="" width="150"></td>
                                        <td>
                                            <a href="{{ url('/admin/product/' . $item->id . '/edit') }}">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"> </i> Edit
                                                </button>
                                            </a>
                                            <a href="{{ route('product.delete', $item->id) }}" onclick='return confirm("Confirm delete?")'>
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Title</th>
                                        <th>Product Price</th>
                                        <th>Product Sku</th>
                                        <th>Product Category</th>
                                        <th>Product Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end">
                                {{$product->links()}}
                   
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')<!-- ============================================================== -->
<script src="{{asset('plugins/components/datatables/jquery.dataTables.min.js')}}"></script>
<script>
$(function () {
    $(document).ready(function(){
            $(".zero-configuration").DataTable({
                "order": [
                    [0, 'desc']
                ],
            });
        });

});
</script>

@endpush
