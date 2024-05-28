@extends('layouts.main')
@section('content')
    <!-- ============================================================== -->
    <!-- BODY START HERE -->
    <!-- ============================================================== -->
    <div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
        <div class="custom-container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('categoryDetail', ['id' => $product_detail->categorys->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $product_detail->categorys->name)))]) }}">{{ $product_detail->categorys->name }}</a>
                    </li>
                    @if($product_detail->subcategory != null)
                    <li>
                        <a href="{{ route('categoryDetail', ['id' => $product_detail->subcategorys->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $product_detail->subcategorys->name)))]) }}">{{ $product_detail->subcategorys->name }}</a>
                    </li>
                    @endif
                    <li class="active">{{ $product_detail->product_title }}</li>
                </ul>
            </div>
        </div>
    </div>
    
    
    <div class="product-details-area padding-30-row-col pt-75 pb-75">
        <div class="custom-container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9 col-md-12 col-12">
                    <div class="product-details-wrap">
                        <div class="product-details-wrap-top">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="product-details-slider-wrap">
                                        <div class="pro-dec-big-img-slider">
                                            <div class="single-big-img-style">
                                                <div class="pro-details-big-img">
                                                    @if (@getimagesize($product_detail->image) != false)
                                                    <a class="img-popup" href="{{ asset($product_detail->image) }}">
                                                        <img src="{{ asset($product_detail->image) }}" alt="">
                                                    </a>
                                                    @else
                                                    <a class="img-popup" href="{{ asset('uploads/products/no_image.jpg') }}">
                                                        <img src="{{ asset('uploads/products/no_image.jpg') }}" alt="">
                                                    </a>
                                                  
                                                    @endif
                                                </div>
                                            </div>
                                            @foreach($product_images as $product_image)
                                            <div class="single-big-img-style">
                                                <div class="pro-details-big-img">
                                                    <a class="img-popup" href="{{ asset($product_image->image) }}">
                                                        <img src="{{ asset($product_image->image) }}" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="product-dec-slider-small product-dec-small-style1">
                                            <div class="product-dec-small active">
                                                <img src="{{ asset($product_detail->image) }}" alt="">
                                            </div>
                                            @foreach($product_images as $product_image)
                                            <div class="product-dec-small">
                                                <img src="{{ asset($product_image->image) }}" alt="">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <form class="h-100 d-flex flex-column justify-content-center align-items-start" method="post" action="{{ route('save_cart') }}" id="add-cart">
                                        @csrf
                                        <input type="hidden" name="product_id" id="product_id" value="{{ $product_detail->id }}">
                                        <div class="product-details-content pro-details-content-pl">
                                            <div class="pro-details-category">
                                                <ul>
                                                    <li><a href="{{ route('categoryDetail', ['id' => $product_detail->categorys->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $product_detail->categorys->name)))]) }}">{{ $product_detail->categorys->name }}</a></li>
                                                    @if($product_detail->subcategory != null)
                                                    <li>/</li>
                                                    <li><a href="{{ route('categoryDetail', ['id' => $product_detail->subcategorys->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $product_detail->subcategorys->name)))]) }}">{{ $product_detail->subcategorys->name }}</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <h1>{{ $product_detail->product_title }}</h1>
                                            <div class="pro-details-price-short-description">
                                                <div class="pro-details-price">
                                                    
                                                    @if($product_detail->list_price < 25.00 || $product_detail->list_price > 999.99)
                                                    <a class="quote" href="tel:{{ App\Http\Traits\HelperTrait::returnFlag(59) }}">
                                                    <p>Call us for Pricing</p>    
                                                    <img src="{{ asset('images/phone-icon.png') }}">
                                                    </a>
                                                    @else
                                                    <span class="new-price">${{ $product_detail->list_price }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="pro-details-quality-stock-area">
                                                <span>Quantity</span>
                                                <div class="pro-details-quality-stock-wrap">
                                                    <div class="product-quality">
                                                        <input class="cart-plus-minus-box input-text qty text" name="qty" value="1" id="counter">
                                                    </div>
                                                    <!--<div class="pro-details-stock">-->
                                                    <!--    <span><i class="fas fa-check-circle"></i> {{ $product_detail->stock }} in stock</span>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                            @if($product_detail->list_price < 25.00 || $product_detail->list_price > 999.99)
                                            <div class="pro-details-action-wrap">
                                                <div class="pro-details-add-to-cart">
                                                    <button type="button" data-toggle="modal" data-target="#exampleModalCenter">Request for Product</button>
                                                </div>
                                            </div>
                                            @else
                                            <div class="pro-details-action-wrap">
                                                <div class="pro-details-add-to-cart">
                                                    <button type="button" id="btn_add_to_cart">Add to cart</button>
                                                    <button id="btn_request_information" type="button">Request information</button>
                                                    <br />
                                                    <div id="request_information_wrapper" class="row mt-4" hidden>
                                                        <form action="" id="form_request_information">
                                                            <div class="col-6 my-2">
                                                                <input type="text" name="first_name" id="form_first_name" placeholder="First name" required>
                                                            </div>
                                                            <div class="col-6 my-2">
                                                                <input type="text" name="last_name" id="form_last_name" placeholder="Last name" required>
                                                            </div>
                                                            <div class="col-6 my-2">
                                                                <input type="text" name="phone" id="form_phone" placeholder="Phone number" required>
                                                            </div>
                                                            <div class="col-6 my-2">
                                                                <input type="email" name="email" id="form_email" placeholder="Email address" required>
                                                            </div>
                                                            <div class="col-6 my-2">
                                                                <textarea name="how_can_we_help_you" id="form_how_can_we_help_you" cols="30" rows="10" placeholder="How can we help you?"></textarea>
                                                            </div>
                                                            <div class="col-6 my-2">
                                                                <textarea name="questions" id="form_questions" cols="30" rows="10" placeholder="Please Enter Your Questions Below*" required></textarea>
                                                            </div>
                                                            <div class="col-12 text-center">
                                                                <button class="btn btn-block" id="btn_request_information_2">Request information</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <hr />
                                                    <label for="">Share</label>
                                                    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=60ad47e8bfb0df0011352a02&product=inline-share-buttons" async="async"></script>
                                                    <a href="#" class="sharethis-inline-share-buttons">  </a>
                                                </div>
                                            </div>
                                            <div class="pro-details-quality-stock-area">
                                                <span>Invite a friend</span>
                                                <div class="pro-details-quality-stock-wrap">
                                                    <form action="#">
{{--                                                        @csrf--}}
                                                        <div class="mtmain" style="margin-left: 14px;">
                                                            <input type="email" id="input_email" class="text" name="email" placeholder="abc@example.com" required>
                                                        </div>
                                                        <div style="margin-left: 14px;">
                                                            <button type="submit" id="btn_invite_friend" class="btn btn-primary">Invite</button>
                                                        </div>
                                                        @error('error')
                                                            <div class="col-12">
                                                                <p style="background: #ffdede; color: red; padding: 17px; text-align: center;">{{$message}}</p>
                                                            </div>
                                                        @enderror
                                                        @if(session()->has('success'))
                                                            <div class="col-12">
                                                                <p style="background: #d2f6a1; color: green; padding: 17px; text-align: center;">{{session()->get('success')}}</p>
                                                            </div>
                                                        @endif
                                                    </form>
                                                    <!--<div class="pro-details-stock">-->
                                                <!--    <span><i class="fas fa-check-circle"></i> {{ $product_detail->stock }} in stock</span>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                            @endif
                                            <div class="product-details-meta">
                                                <ul>
                                                    @if($product_detail->sku != 0)
                                                    <li><span>SKU: </span> {{ $product_detail->sku }}</li>
                                                    @endif
                                                    @if($product_detail->width != 0)
                                                    <li><span>Width: </span> {{ $product_detail->width }}</li>
                                                    @endif
                                                    @if($product_detail->height != 0)
                                                    <li><span>Height: </span> {{ $product_detail->height }}</li>
                                                    @endif
                                                    @if($product_detail->length != 0)
                                                    <li><span>Length: </span> {{ $product_detail->length }}</li>
                                                    @endif
                                                    <li><span>Item Number:</span> {{ $product_detail->item_number }} </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="product-details-wrap-bottom">
                            <div class="product-details-description">
                                <div class="entry-product-section-heading">
                                    <h2>Description</h2>
                                    <span class="descc">{!! str_replace('src="/static', 'src="http://www.choiceonemedical.com/static', $product_detail->description) !!}</span>
                                </div>
                                {{--{!! $product_detail->description !!}--}}
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="sidebar-wrapper sidebar-wrapper-mr1">
                        <div class="sidebar-widget sidebar-widget-wrap sidebar-widget-padding-2 mb-20">
                            <h4 class="sidebar-widget-title">Search </h4>
                            <div class="search-style-3">
                                <form action="#">
                                    <input type="text" placeholder="Search…">
                                    <button type="submit"> <i class="far fa-search"></i> </button>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget sidebar-widget-wrap sidebar-widget-padding-1 mb-20">
                            <h4 class="sidebar-widget-title">Featured items </h4>
                            <div class="sidebar-product-wrap">
                                @foreach($featured_product as $featured_products)
                                <div class="single-sidebar-product">
                                    <div class="slidebar-product-img-3">
                                        <a href="{{ route('shopDetail', ['id' => $featured_products->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $featured_products->product_title))) ]) }}"><img src="{{ asset($featured_products->image) }}" alt=""></a>
                                    </div>
                                    <div class="slidebar-product-content-3">
                                        
                                        <h4><a href="{{ route('shopDetail', ['id' => $featured_products->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $featured_products->product_title))) ]) }}">{{ str_limit($featured_products->product_title, $limit = 25, $end = '...') }}</a></h4>
                                        
                                        @if((float)$featured_products->list_price < 25.00 || (float)$featured_products->list_price > 999.99)
                                        <a class="quote" href="tel:{{ App\Http\Traits\HelperTrait::returnFlag(59) }}">
                                            <p>Call us for Pricing</p>    
                                            <!--<img src="{{ asset('images/phone-icon.png') }}">-->
                                        </a>
                                        @else
                                        <div class="slidebar-pro-price">
                                          
                                            <span>${{ $featured_products->list_price }}</span>
                                           
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="product-area border-top-2 pt-75 pb-70">
        <div class="custom-container">
            <div class="section-title-1 mb-40">
                <h2>Related products</h2>
            </div>
            <div class="product-slider-active-1 nav-style-2 nav-style-2-modify-3">
                @foreach($shops as $shop)
                <div class="product-plr-1">
                    <div class="single-product-wrap">
                        <div class="product-img-action-wrap mb-20">
                            <div class="product-img product-img-zoom">
                                <a href="{{ route('shopDetail', ['id' => $shop->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $shop->product_title))) ]) }}">
                                    @if (@getimagesize($shop->image) != false)
                                    <img class="default-img" src="{{ asset($shop->image) }}" alt="">
                                    @else
                                    <img class="default-img" src="{{ asset('uploads/products/no_image.jpg') }}" alt="">
                                    @endif
                                </a>
                            </div>
                            <div class="product-action-1">
                                <button aria-label="Add To Cart"><i class="far fa-shopping-bag"></i></button>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="{{ route('categoryDetail', ['id' => $shop->categorys->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $shop->categorys->name)))]) }}">{{ $shop->categorys->name }}</a>
                            </div>
                            <h2><a href="{{ route('shopDetail', ['id' => $shop->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $shop->product_title))) ]) }}">{{ $shop->product_title }}</a></h2>
                            <div class="product-price">
                                @if((float)$shop->list_price < 25.00 || (float)$shop->list_price > 999.99)
                                <a class="quote" href="tel:{{ App\Http\Traits\HelperTrait::returnFlag(59) }}">
                                    <p>Call us for Pricing</p>    
                                    <!--<img src="{{ asset('images/phone-icon.png') }}">-->
                                </a>
                                @else
                                <span>${{ $shop->list_price }} </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    
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
    <!-- ============================================================== -->
    <!-- BODY END HERE -->
    <!-- ============================================================== -->
    
    
    <!--modal-->
    
 
       
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Request for Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              
              <div class="modal-body">
                  @php
                  $url = url()->full();
                  @endphp
                  <!--@dump($url)-->
                  <form id="querysubmit">
                        @csrf
            
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="billing-info-wrap padding-20-row-col">
                                        <!--<h3>Billing details</h3>-->
                                        <input type="hidden" name="link" id="link" value="{{ $url }}"/>
                                        <input type="hidden" name="form_name" id="form_name" value="Request for Product" />
            
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info input-style mb-35">
                                                    <label>First Name *</label>
                                                    <input type="text" id="f-name" name="fname" placeholder="First Name"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info input-style mb-35">
                                                    <label>Last Name *</label>
                                                    <input type="text" id="l-name" name="lname" placeholder="Last Name"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info input-style mb-35">
                                                    <label>Company Name *</label>
                                                    <input type="text" name="last_company" placeholder="Company Name" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info input-style mb-35">
                                                    <label>Phone Number *</label>
                                                    <input type="tel" id="phone" name="phone" required>
                                                    <span id="validmsg" class="hide">✓ Valid</span>
                                                    <span id="errormsg" class="hide"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info input-style mb-35">
                                                    <label>Email *</label>
                                                    <input type="email" id="email" name="email"
                                                        placeholder="Enter your Email Address" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info input-style mb-35">
                                                    <label>Address *</label>
                                                    <textarea placeholder="Address" name="address"></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info input-style mb-35">
                                                    <label>Order notes (optional)</label>
                                                    <textarea placeholder="Notes about your order, e.g. special notes for delivery." name="notes"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                         <button class="md-db-1" type="submit">SUBMIT</button>
                                        
                                    </div>
                                </div>
            
                              
                            </div>
                        </div>
                    </form>
                    <div class="mt-3" id="querysubmitresult">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>






            <form id="form_invite_friend" action="{{route('invite-friend')}}" method="POST" hidden>
                <input type="hidden" name="product_image" value="{{(@getimagesize($product_detail->image) != false) ? asset($product_detail->image) : asset('uploads/products/no_image.jpg')}}">
                <input type="hidden" name="product_title" value="{{$product_detail->product_title}}">
                @csrf
            </form>
    
    
    
    
    
@endsection
@section('css')
    <style>
        h1.red {
            font-size: 70px;
        }

        section.main-pro-dtail {
            padding: 100px 0px;
        }

        .variation h2 {
            width: 100%;
            font-size: 18px;
            font-weight: bold;
        }

        .variation {
            padding: 0px 0px 20px 0px;
        }

        .wunty-check h1 {
            width: 100%;
            font-size: 18px;
            font-weight: bold;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .variation select {
            width: 100%;
            height: 36px;
            padding: 0px 10px;
            text-transform: capitalize;
            font-weight: 400;
        }

        .qty .count {
            color: #000;
            display: inline-block;
            vertical-align: top;
            font-size: 25px;
            font-weight: 700;
            line-height: 30px;
            padding: 0 2px;
            min-width: 35px;
            text-align: center;
        }

        .qty .plus {
            cursor: pointer;
            display: inline-block;
            vertical-align: top;
            color: white;
            width: 30px;
            height: 30px;
            font: 30px/1 Arial, sans-serif;
            text-align: center;
            border-radius: 50%;
        }

        .qty .minus {
            cursor: pointer;
            display: inline-block;

            vertical-align: top;
            color: white;
            width: 30px;
            height: 30px;
            font: 30px/1 Arial, sans-serif;
            text-align: center;
            border-radius: 50%;
            background-clip: padding-box;
        }

        .minus:hover {
            background-image: -webkit-linear-gradient(-180deg, rgb(254, 109, 14) 0%, rgb(253, 66, 23) 100%);
        }

        .plus:hover {
            background-image: -webkit-linear-gradient(-180deg, rgb(254, 109, 14) 0%, rgb(253, 66, 23) 100%);
        }

        input.count {
            border: 0;
            width: 2%;
        }
        
        a.quote {
            display: flex;
            align-items: center;
        }
        
        button.md-db-1 {
            color: #ffffff;
            padding: 0;
            border: 0;
            font-size: 15px;
            font-weight: 700;
            border-radius: 26px;
            padding: 10px 41px 12px;
            background-color: #4e97fd;
        }
        
        button.close {
            background: transparent;
            border: none;
            font-size: 40px;
        }
        
        h5#exampleModalLongTitle {
            font-size: 30px;
        }

    </style>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).on('click', "#addCart", function(e) {
            console.log($('#addcount').val())
            $('#add-cart').submit();
        });

        $(document).on('ready', function() {
            $('#btn_invite_friend').on('click', (e) => {
                e.preventDefault();
                if ($('#input_email').val() == "") {
                    return 0;
                }

                $('#form_invite_friend').append('<input name="email" value="'+$('#input_email').val()+'" required>');
                $('#form_invite_friend').append('<input name="link" value="{{\Illuminate\Support\Facades\URL::current()}}" required>');
                $('#form_invite_friend').submit();
            });

            $('#btn_request_information').on('click', function () {
                $('#request_information_wrapper').prop('hidden', !($('#request_information_wrapper').prop('hidden')));
            });

            $('#btn_request_information_2').on('click', function (e) {
                e.preventDefault();

                let data = $('#form_request_information').serialize();
                alert(data);
                console.log(data);

                // if (!form.checkValidity()) {
                //     return form.reportValidity();
                // }

                $.ajax({
                    url: '{{route('request-information')}}',
                    method: 'POST',
                    data: {
                        "_token": '{{csrf_token()}}',
                        "first_name": $('#form_first_name').val(),
                        "last_name": $('#form_last_name').val(),
                        "phone": $('#form_phone').val(),
                        "email": $('#form_email').val(),
                        "how_can_we_help_you": $('#form_how_can_we_help_you').val(),
                        "questions": $('#form_questions').val(),
                    },
                    success: (data) => {
                        alert(data);
                        console.log(data);
                    }
                });
            });

            $('#btn_add_to_cart').on('click', function (e) {
                e.preventDefault();
                $('#add-cart').submit();
            });
        });

    </script>
@endsection
