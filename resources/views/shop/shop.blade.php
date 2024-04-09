@extends('layouts.main')
@section('content')
<?php
    use App\wishlists;
?>
<div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
    <div class="custom-container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="active">Products</li>
            </ul>
        </div>
    </div>
</div>

<div class="shop-area pt-75 pb-55">
    <div class="custom-container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="shop-topbar-wrapper">
                    <div class="totall-product">
                        <p> We found <span>{{ $shops->total() }}</span> products available for you</p>
                    </div>
                    <div class="sort-by-product-area">
                        <div class="sort-by-product-wrap">
                            <div class="sort-by">
                                <span><i class="far fa-align-left"></i>Sort by:</span>
                            </div>
                            <div class="sort-by-dropdown-wrap">
                                <span><span id="filtertext"></span> <i class="far fa-angle-down"></i></span>
                            </div>
                        </div>
                        <div class="sort-by-dropdown">

                                <ul>
                                <li>
                                    @if(Request::segment(1) == "store")
                                    <a href="{{ route('sort',['method' => 'latest']) }}">
                                    @elseif (Request::segment(1) == "filter")
                                    <a class="{{ (Request::segment(2) == "latest") ? 'active' : '' }}" href="{{ route('sort',['method' => 'latest','category'=>Request::segment(3),'id'=>Request::segment(4),'slug'=>Request::segment(5)]) }}">
                                    @else
                                        <a class="{{ (Request::segment(2) == "latest") ? 'active' : '' }}" href="{{ route('sort',['method' => 'latest','category'=>Request::segment(1),'id'=>Request::segment(2),'slug'=>Request::segment(3)]) }}">
                                    @endif
                                        Latest</a>
                                    </li>
                                    <li>
                                        @if(Request::segment(1) == "store")
                                            <a class="{{ (Request::segment(2) == "low-to-high") ? 'active' : '' }}" href="{{ route('sort',['method' => 'low-to-high']) }}">
                                        @elseif (Request::segment(1) == "filter")

                                        <a class="{{ (Request::segment(2) == "low-to-high") ? 'active' : '' }}"  href="{{ route('sort',['method' => 'low-to-high','category'=>Request::segment(3),'id'=>Request::segment(4),'slug'=>Request::segment(5)]) }}">

                                        @else
                                            <a class="{{ (Request::segment(2) == "low-to-high") ? 'active' : '' }}" href="{{ route('sort',['method' => 'low-to-high','category'=>Request::segment(1),'id'=>Request::segment(2),'slug'=>Request::segment(3)]) }}">
                                        @endif
                                         Price: low to high</a>
                                    </li>
                                    <li>
                                        @if(Request::segment(1) == "store")
                                        <a class="{{ (Request::segment(2) == "high-to-low") ? 'active' : '' }}" href="{{ route('sort',['method' => 'high-to-low']) }}">
                                    @elseif (Request::segment(1) == "filter")

                                    <a class="{{ (Request::segment(2) == "high-to-low") ? 'active' : '' }}" href="{{ route('sort',['method' => 'high-to-low','category'=>Request::segment(3),'id'=>Request::segment(4),'slug'=>Request::segment(5)]) }}">

                                    @else
                                        <a class="{{ (Request::segment(2) == "high-to-low") ? 'active' : '' }}" href="{{ route('sort',['method' => 'high-to-low','category'=>Request::segment(1),'id'=>Request::segment(2),'slug'=>Request::segment(3)]) }}">
                                    @endif
                                         Price: high to low</a>
                                    </li>
                                    <li>
                                        @if(Request::segment(1) == "store")
                                        <a class="{{ (Request::segment(2) == "A-Z") ? 'active' : '' }}" href="{{ route('sort',['method' => 'A-Z']) }}">
                                    @elseif (Request::segment(1) == "filter")

                                    <a class="{{ (Request::segment(2) == "A-Z") ? 'active' : '' }}" href="{{ route('sort',['method' => 'A-Z','category'=>Request::segment(3),'id'=>Request::segment(4),'slug'=>Request::segment(5)]) }}">

                                    @else
                                        <a class="{{ (Request::segment(2) == "A-Z") ? 'active' : '' }}" href="{{ route('sort',['method' => 'A-Z','category'=>Request::segment(1),'id'=>Request::segment(2),'slug'=>Request::segment(3)]) }}">
                                    @endif
                                        A-Z</a>
                                    </li>
                                    <li>
                                        @if(Request::segment(1) == "store")
                                        <a class="{{ (Request::segment(2) == "Z-A") ? 'active' : '' }}" href="{{ route('sort',['method' => 'Z-A']) }}">
                                    @elseif (Request::segment(1) == "filter")

                                    <a  class="{{ (Request::segment(2) == "Z-A") ? 'active' : '' }}" href="{{ route('sort',['method' => 'Z-A','category'=>Request::segment(3),'id'=>Request::segment(4),'slug'=>Request::segment(5)]) }}">

                                    @else
                                        <a  class="{{ (Request::segment(2) == "Z-A") ? 'active' : '' }}" href="{{ route('sort',['method' => 'Z-A','category'=>Request::segment(1),'id'=>Request::segment(2),'slug'=>Request::segment(3)]) }}">
                                    @endif
                                        Z-A</a></li>
                                </ul>


                        </div>
                    </div>
                </div>
             
                <div class="shop-bottom-area">
                    <div class="row">
                        @foreach ($shops as $products)
                            {{--eliminate products without images unless searched by SKU or Item number or Title--}}
                            @if(@getimagesize($products->image) != false || (Request::get('name') == $products->product_title || Request::get('name') == $products->sku || Request::get('name') == $products->item_number))
                                <div class="col-xl-3 col-lg-4 col-md-4 col-12 col-sm-6 wow tmFadeInUp">
                                    <div class="single-product-wrap mb-50 wow tmFadeInUp">
                                        <div class="product-img-action-wrap mb-10">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('shopDetail', ['id' => $products->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $products->product_title))) ]) }}">
                                                    @if (@getimagesize($products->image) != false)
                                                    <img class="default-img" src="{{ asset($products->image) }}" alt="">
                                                    @else
                                                    <img class="default-img" src="{{ asset('uploads/products/no_image.jpg') }}" alt="">
                                                    @endif
                                                    <!--<img class="hover-img" src="assets/images/product/product-7-2.jpg" alt="">-->
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Cart" href="{{ route('shopDetail', ['id' => $products->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $products->product_title))) ]) }}"><i class="far fa-shopping-bag"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="{{ route('categoryDetail', ['id' => $products->categorys->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $products->categorys->name)))]) }}">{{ $products->categorys->name }}</a>
                                            </div>
                                            <h2><a href="{{ route('shopDetail', ['id' => $products->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $products->product_title))) ]) }}">{{ $products->product_title }}</a></h2>
                                            <div class="product-price">
                                                @if((float)$products->list_price < 25.00 || (float)$products->list_price > 999.99)
                                                <a class="quote" href="tel:{{ App\Http\Traits\HelperTrait::returnFlag(59) }}">
                                                    <p>Call us for Pricing</p>
                                                    <!--<img src="{{ asset('images/phone-icon.png') }}">-->
                                                </a>
                                                @else
                                                <span>${{ $products->list_price }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="pro-pagination-style text-center mt-55">
{{--                        {{ $shops->links() }}--}}
                        {!! $shops->appends(request()->input())->links() !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="sidebar-wrapper sidebar-wrapper-mr1">
                    <div class="sidebar-widget sidebar-widget-wrap sidebar-widget-padding-1 mb-20">
                        <h4 class="sidebar-widget-title">Categories </h4>
                        <div class="sidebar-categories-list">
                            <ul>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('categoryDetail', ['id' => $category->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $category->name)))]) }}">{{ $category->name }}</a>
                                    @if(count($category->subcategory) != 0)
                                    <ul>
                                        @foreach ($category->subcategory as $subcategory)
                                        <li><a href="{{ route('subcategory', ['id' => $subcategory->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $subcategory->name)))]) }}">{{ $subcategory->name }}</a></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
    <style>
        .filter_sorting ul.list-group {
            margin-right: 25px !important;
            margin-top: 15px;
        }
    </style>
@endsection
@section('js')
    <script type="text/javascript">
    console.clear();
    $(document).ready(function(){
      $('#filtertext').text($('.sort-by-dropdown a.active').text().trim());
    })

   

    </script>
@endsection
