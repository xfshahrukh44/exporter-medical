<div class="main-wrapper">
    <header class="header-area header-height-2">
        <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="custom-container">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li><a href="tel:{{ App\Http\Traits\HelperTrait::returnFlag(59) }}">{{ App\Http\Traits\HelperTrait::returnFlag(59) }}</a></li>
                                <li><a href="mailto:{{ App\Http\Traits\HelperTrait::returnFlag(218) }}"> {{ App\Http\Traits\HelperTrait::returnFlag(218) }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4">
                        
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info header-info-right">
                            <ul>
                                <li>
                                    <a class="language-dropdown-active" href="#">English <i class="fa fa-chevron-down"></i></a>
                                    <ul class="language-dropdown">
                                        <li><a href="#" data-value="en">English</a></li>
                                        <li><a href="#" data-value="es">Spanish</a></li>
                                        <li><a href="#" data-value="zh-TW">Chinese</a></li>
                                        <li><a href="#" data-value="vi">Vietnamese</a></li>
                                    </ul>
                                </li>
                                    @if(Auth::user())
                                        <li><a href="{{ route('account') }}">{{ Auth::user()->name }}</a></li>
                                    @else
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="custom-container">
                <div class="header-wrap header-space-between">
                    <div class="logo logo-width-1">
                        <a href="{{ route('home') }}"><img src="{{ asset("images/logogif.gif") }}" alt="logo"></a>
                    </div>
                    <div class="search-style-2">
                        <form action="{{ route('shop') }}" method="get">
                           
                            
                             @php
                             
                             $cat = App\Category::all();
                             
                             @endphp
                            <select name="category">
                                <option value="" {{ Request::get('category') == null ? 'selected' : '' }}>Categories</option>
                                @foreach($cat as $cats)
                                
                                <option value="{{ $cats->id }}" {{ Request::get('category') == $cats->id ? 'selected' : '' }}>{{ $cats->name }}</option>
                                
                                @endforeach
                                
                                
                              
                            </select>
                            <input type="text" name="name" placeholder="Search for items…" value="{{ Request::get('name') }}">
                            <button type="submit"> <i class="fa fa-search"></i> </button>
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                            <div class="btn-style-1 checkout">
                                <a  class="font-size-14 btn-1-padding-2" href="https://remsleepdiagnosticscenter.com/">
                                    <i class="fas fa-info-circle"></i>
                                    More info
                                </a>
                            </div>
                            <div class="headerflex">
                                 <a target="_blank" href="https://remsleepdiagnosticscenter.com/">
                                 <img class="thirdparty" src="{{ asset('images/LOGO.png') }}">
                               
                                 </a>
                                
                            </div>
                                
                                <?php $cartt = Session::get('cart'); ?>
                          
                                <?php if($cartt == null){ ?>
                                    <a class="mini-cart-icon" href="javascript:;">
                                <?php }else{ ?>
                                    <a class="mini-cart-icon" href="{{ route('cart') }}">
                                <?php } ?>
                                    
                                    
                                    <img class="injectable" alt="" src="{{ asset('new/images/icon-img/cart-2.svg') }}">
                                    <span class="pro-count blue">
                                        @php
                                        $cart = Session::get('cart');
                                        @endphp
                                        @if($cart == null)
                                        0
                                        @else
                                        {{count($cart)}}
                                        @endif
                                    </span>
                                </a>
                                 <div class="btn-style-1 checkout">
                                    <a  class="font-size-14 btn-1-padding-2" href="{{route('payonline')}}">Pay Online Here </a>
                                 </div>
                                     @if(Auth::user())
                                    <div class="header-action-icon-2">
                                        <a href="{{ route('account') }}">
                                            <img class="injectable" alt="" src="{{ asset('new/images/icon-img/user.svg') }}">
                                        </a>
                                    </div>
                                    @else
                                     <div class="header-action-icon-2">
                                        <a href="{{ route('signin') }}">
                                            <img class="injectable" alt="" src="{{ asset('new/images/icon-img/user.svg') }}">
                                        </a>
                                    </div>
                                    @endif
                            </div>
                         
                     
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="marquee-box" style=" background: #415da1; padding: 13px 0px 0px; border-bottom: 1px solid #fff;">
            <marquee width="100%" direction="left" height="30px" class="marquee-line" style="color: #fff; font-size: 16px;">
            American's Best HealthCare Solutions Worldwide Distributor
            </marquee>
        </div>    
        <div class="header-bottom header-bottom-bg-color sticky-bar gray-bg sticky-blue-bg">
            <div class="custom-container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset("images/logogif.gif") }}" alt="logo">
                        </a>
                    </div>
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categori-button-active" href="#">
                        <span class="fa fa-bars"></span> Browse Categories <i class="down fa fa-chevron-down"></i> <i class="up fa fa-chevron-up"></i>
                        </a>
                        <div class="categori-dropdown-wrap categori-dropdown-active-large" style="overflow-y: auto; max-height: 983px;">
                            <ul>
                                @php
                                $cats_old = DB::table('categories')->take(14)->get();
                                $cats = DB::table('categories')->orderBy('name', 'ASC')->get();
                                @endphp
                                @foreach($cats as $cat)
                                <li><a href="{{ route('categoryDetail', ['id' => $cat->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $cat->name)))]) }}"><i class="fa fa-bars"></i> {{ $cat->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block main-menu-light-white hover-boder hover-boder-white">
                        <nav>
                            <ul>
                              
                                <li>
                                    <a class="active" href="{{ route('home') }}">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('pages', ['name' => 'wholesale']) }}">Wholesale</a>
                                </li>
                                <li>
                                    <a href="{{ route('shop') }}">Products</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="hotline d-none d-lg-block">
                        <!--<p><i class="fa fa-clock"></i> <span></span> {{ App\Http\Traits\HelperTrait::returnFlag(1972) }}</p>-->
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2 thirdparty-header-action-icon-2">
                                <a target="_blank" href="https://remsleepdiagnosticscenter.com/">
                                    <img class="thirdparty" src="{{ asset('images/LOGO.png') }} ">
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('cart') }}">
                                    <img class="injectable" alt="" src="{{ asset('new/images/icon-img/cart-2.svg') }}">
                                    <span class="pro-count blue">
                                        @php
                                        $cart = Session::get('cart');
                                        @endphp
                                        @if($cart == null)
                                        0
                                        @else
                                        {{count($cart)}}
                                        @endif    
                                    </span>
                                </a>
                            </div>
                            @if(Auth::user())
                            <div class="header-action-icon-2">
                                <a href="{{ route('account') }}">
                                    <img class="injectable" alt="" src="{{ asset('new/images/icon-img/user.svg') }}">
                                </a>
                            </div>
                            @else
                             <div class="header-action-icon-2">
                                <a href="{{ route('signin') }}">
                                    <img class="injectable" alt="" src="{{ asset('new/images/icon-img/user.svg') }}">
                                </a>
                            </div>
                            @endif
                            
                            <div class="header-action-icon-2 d-block d-lg-none">
                                <div class="burger-icon burger-icon-white">
                                    <span class="burger-icon-top"></span>
                                    <span class="burger-icon-bottom"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div id="google_translate_element" style="display: none"></div>
<?php $segment = Request::segments(); ?>
<!--<div class="loadermain">-->
<!--    <div class="kinetic"></div>-->
<!--</div>-->
<!--<div id="google_translate_element" style="display: none"></div>-->
<!--<div class="My-Accout">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1500">-->
<!--                <div class="Mainitem">-->
<!--                    <div class="Account-innertext" data-aos="fade-right" data-aos-duration="1500">-->


<!--                    </div>-->
<!--                    <div class="account-img" data-aos="fade-left" data-aos-duration="1500">-->
<!--                        <div class="form-group">-->

<!--                            <select class="form-control" id="lang">-->
<!--                                <option value="en">English</option>-->
<!--                                <option value="es">Spainish</option>-->
<!--                                <option value="zh-TW">Chinese</option>-->
<!--                            </select>-->
<!--                        </div>-->

<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- HEADER START -->
<!--<header class="TopNav">-->
<!--    <div class="container">-->
<!--        <div class="row ">-->
<!--            <div class="col-md-12" data-aos="fade-down" data-aos-duration="1500">-->
<!--                <div class="customNavbar">-->
<!--                    <nav class="navbar navbar-expand-lg pr-0 pl-0">-->
<!--                        <a class="navbar-brand" href="{{ route("home") }}"><img src="{{ asset($logo->img_path) }}" class="img-fluid"></a>-->

<!--                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"-->
<!--                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">-->
<!--                            <span class="navbar-toggler-icon"></span>-->
<!--                        </button>-->
<!--                        <div class="collapse navbar-collapse " id="navbarNav">-->
<!--                            <ul class="navbar-nav mr-auto ml-auto">-->
<!--                                <li class="nav-item">-->
<!--                                    <a class="nav-link" href="{{ route("home") }}">Home</a>-->
<!--                                </li>-->
<!--                                <li class="nav-item">-->
<!--                                    <a class="nav-link" href="{{ route("wholesale") }}">Wholesale</a>-->
<!--                                </li>-->
<!--                                <li class="nav-item">-->
<!--                                    <a class="nav-link" href="{{ route("shop") }}">Products</a>-->
<!--                                </li>-->

<!--                                <li class="nav-item">-->
<!--                                    <a class="nav-link" href="{{ route("contact") }}">Contact Us </a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="nav-icon">-->
<!--                            <ul>-->
<!--                                <li><a href=""><i class="fa-solid fa-magnifying-glass"></i></a></li>-->
                                <!--<li><a href=""><i class="fa-regular fa-heart"></i></a></li>-->
<!--                                <li><a href="{{ route("cart") }}"><i class="fa-solid fa-bag-shopping"></i></a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </nav>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</header>-->
<!-- HEADER END -->
