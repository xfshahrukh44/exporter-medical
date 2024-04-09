    <footer class="footer-area pt-75 pb-35">
        <div class="custom-container">
            <div class="row">
                <div class="col-width-25 custom-common-column">
                    <div class="footer-widget footer-about mb-30">
                        <div class="footer-logo logo-width-1">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset("images/logogif.gif") }}" alt="logo">
                            </a>
                        </div>
                        <div class="copyright">
                            <p>{{ App\Http\Traits\HelperTrait::returnFlag(499) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-width-22 custom-common-column">
                    <div class="footer-widget mb-40">
                        <h3 class="footer-title">Our Company</h3>
                        <div class="footer-info-list">
                            <ul>
                                <li><a href="{{ route('about') }}"> About Us</a></li>
                                <li><a href="{{ route('pages', ['name' => 'wholesale']) }}">Wholesale</a></li>
                                <li><a href="{{ route('shop') }}">Products</a></li>
                                <li><a href="{{ route('contact') }}"> Contact Us </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-width-22 custom-common-column">
                    <div class="footer-widget mb-40">
                        <h3 class="footer-title">Quick Links</h3>
                        <div class="footer-info-list">
                            <ul>
                                <li><a href="{{ route('pages', ['name' => 'faq']) }}"> FAQ'S</a></li>
                                <li><a href="{{ route('pages', ['name' => 'ordering-information']) }}"> Ordering Information</a></li>
                                <!--<li><a href="{{ route('pages', ['name' => 'shipping-costs-terms']) }}"> Shipping Costs & Terms</a></li>-->
                                <li><a href="{{ route('pages', ['name' => 'return-policy']) }}">Returns Policy</a></li>
                                <li><a href="{{ route('pages', ['name' => 'privacy-practices']) }}"> Privacy Practices </a></li>
                                <li><a href="{{ route('pages', ['name' => 'shipping-information']) }}"> Shipping Information </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-width-31 custom-common-column">
                    <div class="footer-widget mb-40">
                        <h3 class="footer-title">{{ App\Http\Traits\HelperTrait::returnFlag(1971) }}</h3>
                        <div class="app-visa-wrap">
                            
                            <span> {{ App\Http\Traits\HelperTrait::returnFlag(1972) }}</span>
                            <h5><span>P :</span><a href="tel:{{ App\Http\Traits\HelperTrait::returnFlag(59) }}">{{ App\Http\Traits\HelperTrait::returnFlag(59) }}</a></h5>
                            <h5><span>E :</span><a href="mailto:{{ App\Http\Traits\HelperTrait::returnFlag(218) }}">{{ App\Http\Traits\HelperTrait::returnFlag(218) }}</a></h5>
                            <a href="#"><img src="{{ asset('/images/cart.png') }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    </div>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logogif.gif') }}" alt="logo">
                    </a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu">
                            <li>
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
                                   <button class="btn" type="submit"> <i class="far fa-search"></i> </button>
                               </form>
                            </li>
                            <li>
                             <div class="btn-style-1 checkout">
                                    <a  class="font-size-14 btn-1-padding-2" href="{{route('payonline')}}">Pay Online Here </a>
                                 </div>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="{{ route('pages', ['name' => 'wholesale']) }}">Wholesale</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="{{ route('shop') }}">Products</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="{{ route('contact') }}">Contact Us</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="main-categori-wrap mobile-header-border">
                    <a class="categori-button-active-2" href="#">
                    <span class="far fa-bars"></span> Browse Categories <i class="down far fa-chevron-down"></i>
                    </a>
                    <div class="categori-dropdown-wrap categori-dropdown-active-small">
                        <ul>
                            @php
                            $cat = App\Category::all(); 
                            @endphp
                            @foreach($cat as $cats)
                            <li><a href="{{ route('categoryDetail', ['id' => $cats->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $cats->name)))]) }}">{{ $cats->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mobile-header-info-wrap mobile-header-border">
                    <div class="single-mobile-header-info">
                        <a href="{{ route('login') }}">Log In / Sign Up </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="tel:{{ App\Http\Traits\HelperTrait::returnFlag(59) }}">{{ App\Http\Traits\HelperTrait::returnFlag(59) }}</a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a class="mobile-language-active" href="#">Language <span><i class="far fa-angle-down"></i></span></a>
                        <div class="lang-curr-dropdown lang-dropdown-active">
                            <ul class="language-dropdown">
                                <li><a href="#" data-value="en">English</a></li>
                                <li><a href="#" data-value="es">Spanish</a></li>
                                <li><a href="#" data-value="zh-TW">Chinese</a></li>
                                <li><a href="#" data-value="vi">Vietnamese</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
