@extends('layouts.main')
@section('content')
<div class="slider-area">
    <div class="hero-slider-active-2 dot-style-1 dot-style-1-position-1">
        <!--<div class="single-hero-slider single-animation-wrap custom-d-flex custom-align-item-center bg-img">-->
        <!--    <video width="100%" autoplay muted loop>-->
        <!--        <source src="{{ asset('images/Medical.mp4') }}" type="video/mp4">-->
        <!--        <source src="{{ asset('images/Medical.mp4') }}" type="video/ogg">-->
        <!--        Your browser does not support HTML video.-->
        <!--    </video>-->
        <!--</div>-->
        
        
        @foreach($banner as $banners)
        <div class="single-hero-slider single-animation-wrap slider-height-2 custom-d-flex custom-align-item-center bg-img" style="background-image:url({{ asset($banners->image) }});">
            <div class="custom-container">
                <div class="row align-items-center slider-animated-1">
                    <div class="col-lg-6 col-md-6 col-12 col-sm-6">
                        <div class="hero-slider-content-2">
                            
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 col-sm-6">
                        <div class="single-slider-img single-slider-img-1">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="banner-area pb-45 pt-75">
    <div class="custom-container">
        <div class="row">
            <div class="col-lg-8">
                <div class="banner-wrap wow tmFadeInUp mb-30" onclick="location.href='{{ $section[1]->value }}';" style="cursor: pointer;">

                        <div class="banner-img banner-img-zoom" >
                            <a href="{{ $section[1]->value }}">
                                <img src="{{ asset($page->image) }}" alt="">
                            </a>
                        </div>
                        <div class="banner-content-2">
                            {!! $page->content !!}
                            <div class="btn-style-1">
                                <a class="font-size-14 btn-1-padding-2" href="{{ $section[1]->value }}">{{ $section[0]->value }} </a>
                            </div>
                        </div>
                        <div class="banner-badge-2 banner-badge-2-modify-1 banner-badge-2-position1">
                            <h3>
                                <span>Best</span>
                                Selling
                            </h3>
                        </div>
                   
                </div>
            </div>
           
            <div class="col-lg-4" >
                <div class="banner-wrap wow tmFadeInUp mb-30" onclick="location.href='{{ $section[5]->value }}';" style="cursor: pointer;">
                    <a href="{{ $section[5]->value }}">
                        <div class="banner-img banner-img-zoom">
                            <a href="#">
                                <img src="{{ asset($section[3]->value) }}" alt="">
                            </a>
                        </div>
                        <div class="banner-content-2">
                            {!! $section[2]->value !!}
                            <div class="btn-style-1">
                                <a class="font-size-14 btn-1-padding-2" href="{{ $section[5]->value }}">{{ $section[4]->value }}</a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-area pb-30">
    <div class="custom-container">
        <div class="section-title-btn-wrap st-btn-wrap-xs-center wow tmFadeInUp mb-35">
            <div class="section-title-1 section-title-hm2">
                <h2>Featured Products</h2>
            </div>
        </div>
        <div class="row">
            @foreach ($product as $products)
                @if($products->image != '' || @getimagesize($products->image) != false)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-12 col-sm-6">
                        <div class="single-product-wrap mb-50 wow tmFadeInUp">
                            <div class="product-img-action-wrap mb-10">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('shopDetail', ['id' => $products->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $products->product_title))) ]) }}">
                                        @if (@getimagesize($products->thumb_image ) != false)
                                            <img class="default-img" src="{{ asset($products->thumb_image ) }}" alt="">
                                        @elseif (@getimagesize($products->image ) != false)
                                            <img class="default-img" src="{{ asset($products->image ) }}" alt="">
                                        @else
                                            <img class="default-img" src="{{ asset('uploads/products/no_image.jpg') }}" alt="">
                                        @endif
                                    </a>
                                </div>
                                <div class="product-action-1">
                                    <a aria-label="Add To Cart" href="{{ route('shopDetail', ['id' => $products->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $products->product_title))) ]) }}">
                                        <i class="fa fa-shopping-bag"></i>
                                    </a>
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
    </div>
</div>

@foreach($category as $key => $categorys)
<div class="product-area pb-30">
    <div class="custom-container">
        <div class="section-title-btn-wrap st-btn-wrap-xs-center wow tmFadeInUp mb-35">
            <div class="section-title-1 section-title-hm2">
                <h2>{{ $categorys->name }}</h2>
            </div>
            <div class="btn-style-2 mrg-top-xs">
                <a href="{{ route('categoryDetail', ['id' => $categorys->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $categorys->name)))]) }}">View all products <i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
        <div class="row">
            @if(count($categorys->subcategory) != 0)
            <div class="col-lg-3">
                <div class="slidebar-product-wrap slidebar-product-bg-{{$key+1}} wow tmFadeInUp">
                    <div class="slidebar-product-details">
                        <ul>
                            @foreach($categorys->subcategory as $subcategory)
                            <li><a href="{{ route('subcategory', ['id' => $subcategory->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $subcategory->name)))]) }}"><i class="fa fa-long-arrow-alt-right"></i> {{ $subcategory->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
            @else
            <div class="col-lg-12">
            @endif
                <div class="row">
                    @foreach ($categorys->products as $products)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-12 col-sm-6">
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
                                    <a aria-label="Add To Cart" href="{{ route('shopDetail', ['id' => $products->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $products->product_title))) ]) }}">
                                        <i class="fa fa-shopping-bag"></i>
                                    </a>
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<section class="order-sec">
    <img src="{{ asset($section[8]->value) }}">
    <!--<div class="container">-->
    <!--    <div class="row">-->
    <!--        <div class="col-md-12" data-aos="zoom-out" data-aos-duration="1500">-->
    <!--            <div class="order-content">-->
    <!--                {!! $section[6]->value !!}-->
    <!--                <div class="btn-style-1">-->
    <!--                    <a class="font-size-14 btn-1-padding-4" href="{!! $section[7]->value !!}">Shop now </a>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
</section>


<div class="contact-area bg-gray-2">
    <div class="custom-container">
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-12 col-sm-6">
                <div class="single-contact-wrap text-center wow tmFadeInUp">
                    <h4>Address</h4>
                    <p>{!! App\Http\Traits\HelperTrait::returnFlag(519) !!}</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-12 col-sm-6">
                <div class="single-contact-wrap text-center wow tmFadeInUp">
                    <h4>Work inquiries</h4>
                    <p>{{ App\Http\Traits\HelperTrait::returnFlag(218) }}</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-12 col-sm-6">
                <div class="single-contact-wrap text-center wow tmFadeInUp">
                    <h4>Call us</h4>
                    <p>{{ App\Http\Traits\HelperTrait::returnFlag(59) }}</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-12 col-sm-6">
                <div class="single-contact-wrap text-center wow tmFadeInUp">
                    <h4>Open hours</h4>
                    <p>{{ App\Http\Traits\HelperTrait::returnFlag(1972) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
    <style>
    
    h2.f20 {
    font-size: 26px !important;
    }
    @media (max-width: 1440px) {
        h2.f20 {
            font-size: 26px !important;
            font-weight: 500;
        }
        h3.f17{
            font-size: 17px !important;
        }
    }

    </style>
@endsection

@section('js')
    <script type="text/javascript">
        
        @if(Session::has('error'))
            toastr.options =
            {
              	"closeButton" : true,
              	"progressBar" : true
            }
      		toastr.warning("{{ session('error') }}");
        @endif
        @if(Session::has('success'))
          toastr.options =
          {
          	"closeButton" : true,
          	"progressBar" : true
          }
          		toastr.info("{{ session('success') }}");
        @endif
        
    </script>
@endsection
