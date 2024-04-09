@extends('layouts.main')
@section('content')
<!-- ============================================================== -->
<!-- BODY START HERE -->
<!-- ============================================================== -->

<!-- SECTION "DREAM"  START -->
<section class="innerBanner" style="background: url({{ $page->image }});   background-position: center center;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="inner-heading">
                    <h1>{{ $page->page_name }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- SECTION "DREAM"  END -->

<!--laboratory section start-->

<section class="laboratory">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="laboratory-navs">
                    <ul>
                        <li>
                            <a href="#">Home ></a>
                        </li>
                        <li>
                            <a href="#">Product ></a>
                        </li>
                        <li>
                            <a href="#" class="product-nav">Page 1 of 1</a>
                        </li>
                    </ul>
                </div>

                <div class="shop-by-category">
                    <div class="shop-by-category-head">
                        <h4>
                            SHOP BY CATEGORY
                        </h4>
                    </div>

                    <div class="shop-by-category-lists">
                        <ul>
                            <li>
                                <a href="#"><i class="fa-solid fa-arrow-right-long mr-2"></i> Medical Equipments</a>
                            </li>
                            <li>
                                <a href="#" class="laboratory-class"><i class="fa-solid fa-arrow-right-long mr-2"></i>
                                    Laboratory</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-solid fa-arrow-right-long mr-2"></i> Physical Therapy Rehab</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-solid fa-arrow-right-long mr-2"></i> Mobility Equipment</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-solid fa-arrow-right-long mr-2"></i> Daily Living Aids</a>
                            </li>
                        </ul>
                    </div>

                    <div class="filter">
                        <div class="filter-head">
                            <h4>FILTER PRICE</h4>
                        </div>

                        <div class="filter-product">
                            <input type="range" min="1" max="100" value="50"
                                class="slider slick-initialized slick-slider" id="myRange">
                        </div>

                        <div class="filter-product-details">
                            <p>Price: $49 - $86</p>
                        </div>

                        <div class="filter-btn">
                            <button class="btn filter-button">FILTERS</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="products-item" data-aos="fade-up">
                            <div class="product-img">
                                <img src="images/product1.jpg" class="img-fluid" alt="product1">
                            </div>

                            <div class="product-content">
                                <p>PRODUCT NAME GOES HERE</p>

                                <div class="ratings">
                                    <span>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </span>
                                    <span class="ratingNum">(6456)</span>
                                </div>

                                <p>$25.00</p>

                                <a href="product-details.php" class="btn btnland bagBtn">ADD TO BAG</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="products-item" data-aos="fade-down">
                            <div class="product-img">
                                <img src="images/product2.jpg" class="img-fluid" alt="product1">
                            </div>

                            <div class="product-content">
                                <p>PRODUCT NAME GOES HERE</p>

                                <div class="ratings">
                                    <span>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </span>
                                    <span class="ratingNum">(6456)</span>
                                </div>

                                <p>$25.00</p>

                                <a href="product-details.php" class="btn btnland bagBtn">ADD TO BAG</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="products-item" data-aos="fade-up">
                            <div class="product-img">
                                <img src="images/product3.jpg" class="img-fluid" alt="product1">
                            </div>

                            <div class="product-content">
                                <p>PRODUCT NAME GOES HERE</p>

                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                                <span class="ratingNum">(6456)</span>

                                <p>$25.00</p>

                                <a href="product-details.php" class="btn btnland bagBtn">ADD TO BAG</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="products-item" data-aos="fade-down">
                            <div class="product-img">
                                <img src="images/product1.jpg" class="img-fluid" alt="product1">
                            </div>

                            <div class="product-content">
                                <p>PRODUCT NAME GOES HERE</p>

                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                                <span class="ratingNum">(6456)</span>

                                <p>$25.00</p>

                                <a href="product-details.php" class="btn btnland bagBtn">ADD TO BAG</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="products-item" data-aos="fade-up">
                            <div class="product-img">
                                <img src="images/product2.jpg" class="img-fluid" alt="product1">
                            </div>

                            <div class="product-content">
                                <p>PRODUCT NAME GOES HERE</p>

                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                                <span class="ratingNum">(6456)</span>

                                <p>$25.00</p>

                                <a href="product-details.php" class="btn btnland bagBtn">ADD TO BAG</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="products-item" data-aos="fade-down">
                            <div class="product-img">
                                <img src="images/product3.jpg" class="img-fluid" alt="product1">
                            </div>

                            <div class="product-content">
                                <p>PRODUCT NAME GOES HERE</p>

                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                                <span class="ratingNum">(6456)</span>

                                <p>$25.00</p>

                                <a href="product-details.php" class="btn btnland bagBtn">ADD TO BAG</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="products-item" data-aos="fade-up">
                            <div class="product-img">
                                <img src="images/product1.jpg" class="img-fluid" alt="product1">
                            </div>

                            <div class="product-content">
                                <p>PRODUCT NAME GOES HERE</p>

                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                                <span class="ratingNum">(6456)</span>

                                <p>$25.00</p>

                                <a href="product-details.php" class="btn btnland bagBtn">ADD TO BAG</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="products-item" data-aos="fade-down">
                            <div class="product-img">
                                <img src="images/product2.jpg" class="img-fluid" alt="product1">
                            </div>

                            <div class="product-content">
                                <p>PRODUCT NAME GOES HERE</p>

                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                                <span class="ratingNum">(6456)</span>

                                <p>$25.00</p>

                                <a href="product-details.php" class="btn btnland bagBtn">ADD TO BAG</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="products-item" data-aos="fade-up">
                            <div class="product-img">
                                <img src="images/product3.jpg" class="img-fluid" alt="product1">
                            </div>

                            <div class="product-content">
                                <p>PRODUCT NAME GOES HERE</p>

                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                                <span class="ratingNum">(6456)</span>

                                <p>$25.00</p>

                                <a href="product-details.php" class="btn btnland bagBtn">ADD TO BAG</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--laboratory section end-->










@endsection
@section('css')
<style>

</style>
@endsection

@section('js')
<script type="text/javascript"></script>
@endsection
