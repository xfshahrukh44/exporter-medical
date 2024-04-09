@extends('layouts.main')
@section('title', 'Checkout')
@php
    $country = DB::table('countries')->get();
    $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
@endphp
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"
          integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        /*Remove CSS when fedex enable*/
        button#upsbutton {
            padding: 0;
        }

        button#upsbutton img {
            position: unset;
        }

        button#upsbutton {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
            margin-bottom: 10px;
        }

        button#upsbutton p {
            margin-top: 10px;
            font-size: 16px;
            color: #4e97fd;
            font-weight: 700;

        }


        button#upsbutton:hover {
            background: #4e97fd;
            color: white;
        }

        button#upsbutton:hover p {
            color: white;
        }

        button#upsbutton.active p {
            color: white;
        }

        /*Remove CSS when fedex enable*/


        ul.shippingbutton li {
            width: 50%;
            text-align: center;
            position: relative;
            /* background: whitesmoke; */
        }

        .iti.iti--allow-dropdown {
            width: 100%;
        }

        ul.shippingbutton {
            margin-top: 15px;
            margin-bottom: 22px;
        }

        fieldset label {
            margin-bottom: 10px;
        }

        fieldset legend {
            margin-bottom: 14px;
        }

        ul.shippingbutton button {
            background: whitesmoke;
            padding: 20px 0;
            width: 98%;
        }

        .grand-total-wrap .grand-total {
            padding-bottom: 0px !important;
        }

        div#loader img {
            width: 60px;
        }

        fieldset {
            margin: 20px 0;
        }

        img.fedeximg {
            width: 73px;
            position: absolute;
            top: 9px;
            left: 40%;
        }

        img.upsimage {
            position: absolute;
            width: 76px;
            top: -7px;
            left: 40%;
        }

        .payment-accordion img {
            display: inline-block;
            margin-left: 10px;
            background-color: white;
        }

        form#order-place .form-control {
            border-width: 1px;
            border-color: rgb(150, 163, 218);
            border-style: solid;
            border-radius: 8px;
            background-color: transparent;
            height: 54px;
            padding-left: 15px;
            color: black;
        }

        form#order-place textarea.form-control {
            height: auto !important;
        }

        .checkoutPage {
            padding: 50px 0px;
        }

        .checkoutPage .section-heading h3 {
            margin-bottom: 30px;
        }

        div#shippingdiv {
            padding: 0 !important;
        }

        div#shippingdiv ul {
            width: 100%;
        }

        .YouOrder {
            background-color: #ffa859;
            color: white;
            padding: 25px;
            min-height: 300px;
            border-radius: 3px;
            margin-bottom: 20px;
            border-top-left-radius: 0px !important;
            border-top-right-radius: 25px !important;
            border-bottom-right-radius: 0px !important;
            border-bottom-left-radius: 25px !important;
        }

        .amount-wrapper {
            padding-top: 12px;
            border-top: 2px solid white;
            text-align: left;
            margin-top: 90px;
        }

        .amount-wrapper h2 {
            font-size: 20px;
            display: flex;
            justify-content: space-between;
        }

        .amount-wrapper h3 {
            display: FLEX;
            justify-content: SPACE-BETWEEN;
            font-size: 22px;
            border-top: 2px solid white;
            padding-top: 10px;
            margin-top: 14px;
        }

        .checkoutPage span.invalid-feedback strong {
            color: #ffa859;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            display: block;
            width: 100%;
            font-size: 15px;
            padding: 5px 15px;
            border-radius: 6px;
        }

        #authbtn {
            display: inline-block;
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            border-radius: 26px;
            padding: 13px 36px;
            background-color: #4e97fd;
            border: 0px
        }

        .payment-accordion .btn-link {
            display: block;
            width: 100%;
            text-align: left;
            padding: 10px 19px;
            color: black;
        }

        .payment-accordion .card-header {
            padding: 0px !important;
        }

        .payment-accordion .card-header:first-child {
            border-radius: 0px;
        }

        .payment-accordion .card {
            border-radius: 0px;
        }

        .form-group.hide {
            display: none;
        }

        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
            border-width: 1px;
            border-color: rgb(150, 163, 218);
            border-style: solid;
            margin-bottom: 10px;
        }

        button.active {
            background: #415da1 !important;
            color: white;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #ffa859;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        div#card-errors {
            color: #ffa859;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            display: block;
            width: 100%;

            font-size: 15px;
            padding: 5px 15px;
            border-radius: 6px;
            display: none;
            margin-bottom: 10px;
        }

        .fedexlogo img {
            width: 100px;
            margin-bottom: 18px;
        }

        .order-summary-wrapper {
            position: static;
            left: 0%;
            top: 0px;
            right: 0%;
            bottom: auto;
            margin-top: -8%;
            margin-bottom: 0%;
            height: 100%;
        }

        .order-summary-wrapper-inner {
            position: sticky;
            top: 20%;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
        <div class="custom-container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="active">Checkout</li>
                </ul>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="checkout-area pt-75 pb-75">
        <form action="{{ route('order.place') }}" method="POST" id="order-place">
            @csrf
            <input type="hidden" name="fedex_token" value="{{ $fedex_token }}" id="fedex_token">
            <input type="hidden" name="payment_status" value=""/>
            <input type="hidden" name="payment_method" id="payment_method" value="AuthNet"/>
            <input type="hidden" name="shipping" id="shippinginput" value=""/>
            <input type="hidden" name="shippingamount" id="shippingamount" value=""/>

            <input type="hidden" name="amount" id="amount" value=""/>

            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="billing-info-wrap padding-20-row-col">
                            <h3>Billing details</h3>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info input-style mb-35">
                                        <label>First Name *</label>
                                        <input type="text" id="f-name" name="first_name" placeholder="First Name"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info input-style mb-35">
                                        <label>Last Name *</label>
                                        <input type="text" id="l-name" name="last_name" placeholder="Last Name"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info input-style mb-35">
                                        <label>Company Name *</label>
                                        <input type="text" name="company_name" placeholder="Company Name" required>
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
                            </div>

                            <div>
                                <label>Order notes (optional)</label>
                                <textarea placeholder="Notes about your order, e.g. special notes for delivery."
                                          name="message"></textarea>
                            </div>


                            <fieldset id="fedexfieldset">
                                <legend>Shipping Address</legend>
                                <div class="inputfields row">
                                    <div class="billing-info col-md-12 input-style">
                                        <label for="">Type Your Address</label>
                                        <input type="text" id="searchTextField" class="billing-address"
                                               name="googleaddress" onchange="initialize()">
                                    </div>
                                    <div id="addressdiv" style="display: none">
                                        <input type="hidden" name="fedex-checker" value="0" id="fedex-checker">
                                        <div class="select-style col-md-12  mb-35 input-style">
                                            <label>Country *</label>
                                            <input type="text" name="country" id="country" class="billing-address"
                                                   value="DE"> <!-- readonly -->
                                            <!--<input type="hidden" name="country" id="country" class="billing-address" value="US">-->
                                            <!--<select class="select-active form-control" name="country" id="country">-->
                                        <!--    @foreach ($country as $item)-->
                                        <!--        <option {{ $item->sortname == 'US' ? 'selected' : '' }}-->
                                        <!--            value="{{ $item->sortname }}">{{ $item->name }}</option>-->
                                            <!--    @endforeach-->
                                            <!--</select>-->
                                        </div>
                                        <div class="billing-info col-md-12 input-style ">
                                            <label>Street Address *</label>
                                            <input class="billing-address" type="text" id="address"
                                                   name="address_line_1" value="Werrastrasse 13" required>
                                            <!-- readonly -->
                                        </div>

                                        <div class="billing-info col-md-12 input-style">
                                            <label>City *</label>
                                            <input class="billing-address" type="text" id="city" name="city"
                                                   value="Bad Sooden-Allendorf" required>  <!-- readonly -->
                                        </div>
                                        <div class="billing-info col-md-12 input-style">
                                            <label>Postal Code *</label>
                                            <input class="billing-address" type="text" id="postal" name="postal_code"
                                                   value="37242" required>  <!-- readonly -->
                                        </div>
                                        <div class="billing-info col-md-12 input-style">
                                            <label>State Code *</label>
                                            <input class="billing-address" type="text" id="state" name="state"
                                                   value="HE" required>  <!-- readonly -->
                                        </div>

                                    </div>


                                    <div class="billing-info col-md-12 input-style update-btn">
                                        <ul class="nav nav-tabs shippingbutton" id="myTab" role="tablist">
                                            <li class="nav-item shipli" role="presentation" style="display: none">
                                                <button id="fedexbutton" class="btn shippingbtn" type="button">
                                                    <img class="fedeximg" src="{{ asset('images/fedex.png') }}"
                                                         alt="">
                                                </button>
                                            </li>
                                            <li class="nav-item shipli" role="presentation" style="width: 100%">
                                                <button id="upsbutton" class="btn shippingbtn" type="button">
                                                    <p>Calculate Shipping</p>
                                                <!--<img class="upsimage" src="{{ asset('images/ups.png') }}"-->
                                                    <!--    alt="">-->
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-12">
                                        <span id="error" class="text-danger" style="display: none"></span>
                                        <div id="loader" style="display:none">
                                            <img src="{{ asset('images/loader.gif') }}">
                                        </div>
                                        <div id="servicesdiv" class="mb-35" style="display: none">


                                        </div>
                                    </div>

                                </div>


                            </fieldset>

                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="order-summary-wrapper">
                            <div class="order-summary-wrapper-inner">
                                <div class="order-summary">
                                    <div class="order-summary-title">
                                        <h3>Order summary</h3>
                                    </div>
                                    <div class="order-summary-top">
                                        <?php $subtotal = 0;
                                        $addon_total = 0;
                                        $variation = 0; ?>
                                        @foreach ($cart as $key => $value)
                                            @php
                                                $product = DB::table('products')
                                                    ->where('id', $key)
                                                    ->first();
                                            @endphp
                                            <div class="order-summary-img-price">
                                                <div class="order-summary-img-title">
                                                    <div class="order-summary-img">
                                                        <a
                                                                href="{{ route('shopDetail', ['id' => $product->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $product->product_title)))]) }}">
                                                            @if (@getimagesize($product->image) != false)
                                                                <img src="{{ asset($product->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('uploads/products/no_image.jpg') }}"
                                                                     alt="">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="order-summary-title">
                                                        <h4>{{ $value['name'] }} <span>× {{ $value['qty'] }}</span></h4>
                                                    </div>
                                                </div>
                                                <div class="order-summary-price">
                                                    <span>${{ $value['baseprice'] }}</span>
                                                </div>
                                            </div>
                                            <?php
                                            $subtotal += $value['baseprice'] * $value['qty'];
                                            $variation += $value['variation_price'];
                                            ?>
                                        @endforeach
                                    </div>

                                    <div class="order-summary-middle">

                                        <ul>
                                            <li id="li_subtotal">
                                                Subtotal
                                                <h4>${{ $subtotal }}</h4>
                                            </li>
                                            <li id="li_hidden" hidden>
                                                <h4>
                                                    <input type="text" class="text_coupon" style="background: white;"
                                                           placeholder="Enter coupon code">
                                                </h4>
                                                <button class="btn btn-link btn_apply_coupon">Apply coupon</button>
                                            </li>
                                            <li id="desctax" style="display: none">
                                                Sales Tax Description
                                                <h4></h4>
                                            </li>

                                            <li id="taxli" style="display: none">
                                                Sales Tax
                                                <h4>%</h4>
                                            </li>

                                            <li id="ordertotalli" style="display: none">
                                                Order Total
                                                <h4>${{number_format($calculated,2)}}</h4>
                                            </li>

                                        </ul>
                                    </div>

                                    <div id="shippingdiv" class="grand-total-wrap mb-40 shippingdiv"
                                         style="display:none">


                                        </ul>
                                        <ul id="upsli">
                                            <li>
                                                Service Name
                                                <h4 id="servname">UPS Standard</h4>
                                            </li>

                                            <li>
                                                Shipping Total
                                                <h4 id="totalshippingh4">$0.00</h4>
                                            </li>


                                        </ul>
                                        <div class="grand-total">
                                            <h4 class="text-right">Total <span
                                                        id="grandtotal">${{ $subtotal + $shipping['totalshipingamount'] }}</span>
                                            </h4>
                                        </div>


                                    </div>

                                </div>
                                <div id="accordion" class="payment-accordion" style="display:none">
                                    <div class="card" style="margin-left:30px;margin-top:5px;">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button"
                                                        data-toggle="collapse"
                                                        data-target="#collapseThree" aria-expanded="false"
                                                        aria-controls="collapseThree" data-payment="stripe">
                                                    Pay with Card<img src="{{ asset('images/payment1.png') }}" alt=""
                                                                      width="150">
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                             data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group"></div>
                                                    <label for="">Month</label>

                                                    <select class="form-control" id="expiration-month" name="month">
                                                        @foreach ($months as $k => $v)
                                                            <option value="{{ $k }}"
                                                                    {{ old('expiration-month') == $k ? 'selected' : '' }}>
                                                                {{ $v }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group"></div>
                                                    <label for="">Year</label> <select class="form-control"
                                                                                       name="expr" id="expiration-year">

                                                        @for ($i = date('Y'); $i <= date('Y') + 15; $i++)
                                                            <option value="{{ $i }}">
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="cc">Card Number</label>
                                                        <input maxlength="16" type="text" name="cc"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="cvv">CVV</label>
                                                        <input type="number" name="cvv" pattern="\d{3}"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <button type="button" onclick="Auth()" class="mt-40" id="authbtn">
                                                        Pay
                                                        Now
                                                        ${{ $subtotal }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    @endsection
    @section('js')

        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDvh8npnQNdrlU-Ct_gwwHAaMBBDsJQtag"></script>

        <script>
            $("#searchTextField").keydown(function () {
                $('#fedex-checker').val(0);
                $('#accordion').slideUp();
                $('#addressdiv').slideUp();
                $('#desctax').slideUp();
                $('#othertaxli').slideUp();
                $('#cataxli').slideUp();
                $("#shippingdiv").slideUp();
            })

            function initialize() {
                var input = document.getElementById('searchTextField');
                var autocomplete = new google.maps.places.Autocomplete(input);
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    console.log(place);
                    var searchAddressComponents = place.address_components, searchPostalCode = "",
                        searchAddress = "", searchCity = "", searchState = "", searchCountryName = "",
                        searchCountryCode = "";

                    $.each(searchAddressComponents, function () {
                        if (this.types[0] == "postal_code") {
                            searchPostalCode = this.short_name;
                        }
                        if (this.types[0] == "route") {
                            searchAddress = this.short_name;
                        }
                        if (this.types[0] == "locality") {
                            searchCity = this.short_name;
                        }
                        if (this.types[0] == "administrative_area_level_1") {
                            searchState = this.short_name;
                        }
                        if (this.types[0] == "country") {
                            searchCountryName = this.long_name;
                            searchCountryCode = this.short_name;
                        }
                    });

                    var addressArray = place.adr_address.split(',')

                    var country = searchCountryCode;
                    var city = searchCity;
                    var address = searchAddress;
                    var state = searchState;

                    var postalcode = searchPostalCode;
                    $('#country').val(searchCountryCode);
                    $('#country-code').val(searchCountryName);

                    // $('#country option[value="' + country.toString() + '"]').prop('selected', true);
                    $('#city').val(city);
                    $('#address').val(address);
                    $('#state').val(state);
                    $('#postal').val(postalcode);
                    $('#addressdiv').slideDown();
                    $('#fedex-checker').val(1);


                });
            }
        </script>


        <script src="https://www.paypalobjects.com/api/checkout.js"></script>
        <script type="text/javascript" src="https://jstest.authorize.net/v1/Accept.js" charset="utf-8"></script>
        <script type="text/javascript">
            function sendPaymentDataToAnet() {

                $("#payment_method").val("AuthNet");
                if (!$("#validmsg").hasClass("hide")) {
                    $("#order-place").submit();
                } else {
                    toastr.error("Invalid Number");
                }

            }
        </script>
        <script src="https://js.stripe.com/v3/"></script>
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script>
            var input = document.querySelector("#phone"),
                errorMsg = document.querySelector("#errormsg"),
                validMsg = document.querySelector("#validmsg");

            // Error messages based on the code returned from getValidationError
            var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

            // Initialise plugin
            var intl = window.intlTelInput(input, {
                utilsScript: "{{ asset('new/js/utils.js') }}"
            });

            var reset = function () {
                input.classList.remove("error");
                errorMsg.innerHTML = "";
                errorMsg.classList.add("hide");
                validMsg.classList.add("hide");
            };

            // Validate on blur event
            input.addEventListener('blur', function () {
                reset();
                if (input.value.trim()) {
                    if (intl.isValidNumber()) {
                        validMsg.classList.remove("hide");
                    } else {
                        input.classList.add("error");
                        var errorCode = intl.getValidationError();
                        errorMsg.innerHTML = errorMap[errorCode];
                        errorMsg.classList.remove("hide");
                    }
                }
            });

            // Reset on keyup/change event
            input.addEventListener('change', reset);
            input.addEventListener('keyup', reset);
        </script>
        <script>
                $('#order-place').append('<input type="hidden" name="subtotal" value="{{ $subtotal }}" id="fedex_token">');

                $('#upsbutton').click(function () {
                    $('.shippingbtn').removeClass('active');
                    $('#loader').show();
                    $(this).addClass("active");
                    var country = $('#country').val();
                    var address = $('#address').val();
                    var postal = $('#postal').val();

                    var city = $('#city').val();
                    var state = $('#state').val();

                    if (country == '' || address == '' || postal == '' || city == '') {
                        toastr.error('Please fill all address fields')
                    } else {
                        $('#servname').parent().prop('hidden', ($('#country').val() == 'US'));
                        // $('#li_hidden').prop('hidden', false);
                        if ($('#country').val() == 'US') {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                _token: "{{ csrf_token() }}",
                                url: "{{ route('upsservices') }}",
                                type: "post",
                                dataType: "json",
                                data: {
                                    country: country,
                                    address: address,
                                    state: state,
                                    postal: postal,
                                    city: city,

                                },
                                success: function (response) {
                                    if (response.status) {
                                        $('#li_hidden').prop('hidden', false);
                                        console.clear();
                                        console.log(response);
                                        var tax = Number('{{ $subtotal }}') + ((Number(response.tax) / 100) * Number('{{ $subtotal }}'));
                                        $("#ordertotalli h4").text('$' + tax.toString());
                                        var ordertotal = Number(response.upsamount) + Number(tax);
                                        $('#taxli  h4').text(response.tax.toString() + "%")
                                        if (response.description != null) {
                                            $('#desctax h4').text(response.description);
                                            $('#desctax').slideDown();
                                        }

                                        $('#taxli').slideDown();
                                        $('#shippingamount').val(response.upsamount);
                                        $('#servname').text('UPS Standard');
                                        $('#totalshippingh4').text('$' + response.upsamount.toString());
                                        $('#shippingdiv').slideDown();
                                        $('#fedexli').hide();
                                        $('#upsli').slideDown();
                                        $('#grandtotal').text('$ ' + ordertotal.toFixed(2));
                                        $('#amount').val(Number(ordertotal.toFixed(2)));
                                        $('#authbtn').text('Pay Now $' + ordertotal.toFixed(2));
                                        $('#shippinginput').val("UPS");
                                        $('#accordion').slideDown();

                                    } else {
                                        $('#error').text(response.message);
                                        $('#error').show();
                                    }
                                }
                            });
                        } else {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                _token: "{{ csrf_token()}}",
                                url: "{{route('dhlservices')}}",
                                type: "post",
                                data: {
                                    country: country,
                                    address: address,
                                    state: state,
                                    postal: postal,
                                    city: city
                                },
                                dataType: "json",
                                success: function (response) {
                                    $('#li_hidden').prop('hidden', false);

                                    if (response.status) {
                                        console.log(response)

                                        var tax = Number('{{ $subtotal }}') + ((Number(15) / 100) * Number('{{ $subtotal }}'));
                                        console.log(tax)
                                        $('#taxli  h4').text('15%')
                                        var total = tax + Number(response.message);
                                        $('#servname').text('DHL Express');
                                        $('#totalshippingh4').text('$' + response.message.toString());
                                        $("#ordertotalli h4").text('$' + total.toString());

                                        $('#shippingamount').val(response.message);
                                        $('#shippinginput').val("DHL");
                                        $('#grandtotal').text('$ ' + total.toFixed(2));
                                        $('#authbtn').text('Pay Now $' + total.toFixed(2));
                                        $('#amount').val(Number(total.toFixed(2)));
                                        $('#accordion').slideDown();
                                        $('#upsli').slideDown();
                                        $('#shippingdiv').slideDown();
                                        $('#taxli').slideDown();


                                    }
                                }
                            })
                        }

                    }

                    $('#loader').hide();
                    $(this).removeClass('active');


                });

                $('#fedexbutton').click(function () {
                    if ($('#fedex-checker').val() == 0) {
                        $('#error').text('Please Fill out the Address');
                        $('#error').show();
                    } else {
                        $('#accordion').slideUp();
                        $('.shippingbtn').removeClass('active');
                        $(this).addClass("active");
                        $('#error').hide();
                        $('#servicesdiv').slideUp();
                        $('#loader').show();
                        var country = $('#country').val();
                        var address = $('#address').val();
                        var postal = $('#postal').val();
                        var city = $('#city').val();
                        var token = $('#fedex_token').val();
                        var state = $('#state').val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            _token: "{{ csrf_token() }}",
                            url: "{{ route('shipping') }}",
                            type: "post",
                            dataType: "json",
                            data: {
                                country: country,
                                address: address,
                                city: city,
                                postal: postal,
                                state: state,
                                token: token,
                            },
                            success: function (response) {
                                if (response.success) {
                                    console.log(response.tax)
                                    if (response.description != null) {
                                        $('#desctax h4').text(response.description);
                                        $('#desctax').slideDown();
                                    }
                                    var tax = Number('{{ $subtotal }}') + ((Number(response.tax) / 100) * Number('{{ $subtotal }}'));
                                    $("#ordertotalli h4").text('$' + tax.toString());
                                    var ordertotal = (Number(tax) + Number(json[0]['ratedShipmentDetails'][0]['totalNetFedExCharge'])).toFixed(2);
                                    $('#shippingamount').val(json[0]['ratedShipmentDetails'][0]['totalNetFedExCharge']);
                                    $('#loader').hide();
                                    console.log(ordertotal);
                                    $('#servname').text("Fedex Standard");
                                    $('#shippingtotalfed').text('$ ' + json[0]['ratedShipmentDetails'][0]['totalNetFedExCharge'].toString());
                                    $('#grandtotal').text('$' + ordertotal);
                                    $('#shippingdiv').slideDown();
                                    $('#upsli').hide();
                                    $('#fedexli').slideDown();
                                    $('#authbtn').text('Pay Now $' + ordertotal);
                                    $('#amount').val(ordertotal);
                                    $('#shippinginput').val("Fedex");
                                    $('#accordion').slideDown();
                                } else {
                                    $('#loader').hide();
                                    $('#error').text(response.error);
                                    $('#error').show();
                                }

                            }
                        })
                    }
                });


                function Auth() {
                    var error = checkEmptyFileds();
                    if (error != 0) {
                        toast({
                            heading: 'Alert!',
                            position: 'bottom-right',
                            text: 'Please fill the required fields before proceeding to pay',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 5000,
                            stack: 6
                        });
                    } else {
                        var form = document.getElementById('order-place');
                        $('input[name="payment_method"]').val('AuthNet');
                        if (!$('#validmsg').hasClass("hide")) {
                            form.submit();
                        } else {
                            toastr.error("Invalid Number");
                        }

                    }
                }

                $('.auth').change(function () {
                    alert(this.value);
                    $('input[name="' + this.id + '"]').val(this.value)
                });

                $('#accordion .btn-link').on('click', function (e) {
                    if (!$(this).hasClass('collapsed')) {
                        e.stopPropagation();
                    }
                    $('#payment_method').val($(this).attr('data-payment'));
                });

                $('.bttn').on('change', function () {
                    var count = 0;
                    if ($(this).prop("checked") == true) {
                        if ($('#f-name').val() == "") {
                            $('.fname').text('first name is required field');
                        } else {
                            $('.fname').text("");
                            count++;
                        }
                        if ($('#l-name').val() == "") {
                            $('.lname').text('last name is required field');
                        } else {
                            $('.lname').text("");
                            count++;
                        }

                        if (count == 2) {
                            $('#paypal-button-container-popup').show();
                        } else {
                            $(this).prop("checked", false);

                            $.toast({
                                heading: 'Alert!',
                                position: 'bottom-right',
                                text: 'Please fill the required fields before proceeding to pay',
                                loaderBg: '#ff6849',
                                icon: 'error',
                                hideAfter: 5000,
                                stack: 6
                            });

                            return false;

                        }

                    } else {
                        $('#paypal-button-container-popup').hide();
                        // $('.btn').show();
                    }

                    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
                    //$(this).siblings('input[type="checkbox"]').prop('checked', false);
                });

                const renderPaypalButton = (amount = {{number_format(((float)$subtotal),2, '.', '')}}) => {
                    paypal.Button.render({
                        env: 'sandbox', //production

                        style: {
                            label: 'checkout',
                            size: 'responsive',
                            shape: 'rect',
                            color: 'gold'
                        },
                        client: {
                            sandbox: 'AV06KMdIerC8pd6_i1gQQlyVoIwV8e_1UZaJKj9-aELaeNXIGMbdR32kDDEWS4gRsAis6SRpUVYC9Jmf',
                            // production:'ARIYLCFJIoObVCUxQjohmqLeFQcHKmQ7haI-4kNxHaSwEEALdWABiLwYbJAwAoHSvdHwKJnnOL3Jlzje',
                        },
                        validate: function (actions) {
                            actions.disable();
                            paypalActions = actions;
                        },

                        onClick: function (e) {
                            var errorCount = checkEmptyFileds();

                            if (errorCount == 1) {
                                $.toast({
                                    heading: 'Alert!',
                                    position: 'bottom-right',
                                    text: 'Please fill the required fields before proceeding to pay',
                                    loaderBg: '#ff6849',
                                    icon: 'error',
                                    hideAfter: 5000,
                                    stack: 6
                                });
                                paypalActions.disable();
                            } else {
                                paypalActions.enable();
                            }
                        },
                        payment: function (data, actions) {
                            return actions.payment.create({
                                payment: {
                                    transactions: [{
                                        {{--amount: {--}}
                                        {{--    total: {{ number_format(((float) $subtotal), 2, '.', '') }},--}}
                                        {{--    currency: 'USD'--}}
                                        {{--}--}}
                                        amount: {total: amount, currency: 'USD'}
                                    }]
                                }
                            });
                        },
                        onAuthorize: function (data, actions) {
                            return actions.payment.execute().then(function () {
                                // generateNotification('success','Payment Authorized');

                                $.toast({
                                    heading: 'Success!',
                                    position: 'bottom-right',
                                    text: 'Payment Authorized',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 1000,
                                    stack: 6
                                });

                                var params = {
                                    payment_status: 'Completed',
                                    paymentID: data.paymentID,
                                    payerID: data.payerID
                                };

                                // console.log(data.paymentID);
                                // return false;
                                $('input[name="payment_status"]').val('Completed');
                                $('input[name="payment_id"]').val(data.paymentID);
                                $('input[name="payer_id"]').val(data.payerID);
                                $('input[name="payment_method"]').val('paypal');
                                $('#order-place').submit();
                            });
                        },
                        onCancel: function (data, actions) {
                            var params = {
                                payment_status: 'Failed',
                                paymentID: data.paymentID
                            };
                            $('input[name="payment_status"]').val('Failed');
                            $('input[name="payment_id"]').val(data.paymentID);
                            $('input[name="payer_id"]').val('');
                            $('input[name="payment_method"]').val('paypal');
                        }
                    }, '#paypal-button-container-popup');
                }
                renderPaypalButton();


                var stripe = Stripe('{{ env('STRIPE_KEY') }}');

                // Create an instance of Elements.
                var elements = stripe.elements();
                var style = {
                    base: {
                        color: '#32325d',
                        lineHeight: '18px',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };
                var card = elements.create('card', {
                    style: style
                });
                card.mount('#card-element');

                card.addEventListener('change', function (event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        $(displayError).show();
                        displayError.textContent = event.error.message;
                    } else {
                        $(displayError).hide();
                        displayError.textContent = '';
                    }
                });

                var form = document.getElementById('order-place');

                $('#stripe-submit').click(function () {
                    stripe.createToken(card).then(function (result) {
                        var errorCount = checkEmptyFileds();
                        if ((result.error) || (errorCount == 1)) {
                            // Inform the user if there was an error.
                            if (result.error) {
                                var errorElement = document.getElementById('card-errors');
                                $(errorElement).show();
                                errorElement.textContent = result.error.message;
                            } else {
                                $.toast({
                                    heading: 'Alert!',
                                    position: 'bottom-right',
                                    text: 'Please fill the required fields before proceeding to pay',
                                    loaderBg: '#ff6849',
                                    icon: 'error',
                                    hideAfter: 5000,
                                    stack: 6
                                });
                            }
                        } else {
                            // Send the token to your server.
                            stripeTokenHandler(result.token);
                        }
                    });
                });

                function stripeTokenHandler(token) {
                    // Insert the token ID into the form so it gets submitted to the server
                    var form = document.getElementById('order-place');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }


                function checkEmptyFileds() {
                    var errorCount = 0;
                    $('form#order-place').find('.form-control').each(function () {
                        if ($(this).prop('required')) {
                            if (!$(this).val()) {
                                $(this).parent().find('.invalid-feedback').addClass('d-block');
                                $(this).parent().find('.invalid-feedback strong').html('Field is Required');
                                errorCount = 1;
                            }
                        }
                    });
                    return errorCount;
                }
            </script>

        <script>
            const mutate_front_total = (amount) => {
                let total = parseFloat($('#grandtotal').html().replace('$', ''))
                total += amount;
                return $('#grandtotal').html('$ ' + total.toFixed(2));
            }

            $('.btn_apply_coupon').on('click', () => {
                let coupon_value = $('.text_coupon').val();

                if (coupon_value == '5500') {
                    $('#order-place').append('<input hidden name="no_shipping" value="true">');
                    mutate_front_total(parseFloat($('#totalshippingh4').html().replace('$', '')) * -1);
                    $('#totalshippingh4').html('$ 0');
                    toastr.success('No Shipping coupon applied!');
                    $('.btn_apply_coupon').parent().remove();
                } else if (coupon_value == '5050') {
                    $('#order-place').append('<input hidden name="no_tax" value="true">');
                    mutate_front_total(parseFloat($('#li_subtotal').find('h4').html().replaceAll('$', '')) * (parseFloat($('#taxli').find('h4').html().replaceAll('$', '')) / 100) * -1);
                    $('#taxli').find('h4').html('0%');
                    toastr.success('No Tax coupon applied!');
                    $('.btn_apply_coupon').parent().remove();
                } else if (coupon_value == '1010') {
                    $('#order-place').append('<input hidden name="ten_off" value="true">');
                    mutate_front_total(parseFloat($('#li_subtotal').find('h4').html().replaceAll('$', '')) * 0.1 * -1);
                    // $('#taxli').find('h4').html('0%');
                    toastr.success('10% off coupon applied!');
                    $('.btn_apply_coupon').parent().remove();
                } else if (coupon_value == '2020') {
                    $('#order-place').append('<input hidden name="twenty_off" value="true">');
                    mutate_front_total(parseFloat($('#li_subtotal').find('h4').html().replaceAll('$', '')) * 0.1 * -1);
                    // $('#taxli').find('h4').html('0%');
                    toastr.success('20% off coupon applied!');
                    $('.btn_apply_coupon').parent().remove();
                } else if (coupon_value == 'REP01') {
                    $('#order-place').append('<input hidden name="sales_rep_01" value="true">');
                    toastr.success('Sales rep coupon applied!');
                    $('.btn_apply_coupon').parent().remove();
                } else if (coupon_value == 'REP02') {
                    $('#order-place').append('<input hidden name="sales_rep_02" value="true">');
                    toastr.success('Sales rep coupon applied!');
                    $('.btn_apply_coupon').parent().remove();
                } else if (coupon_value == 'REP03') {
                    $('#order-place').append('<input hidden name="sales_rep_03" value="true">');
                    toastr.success('Sales rep coupon applied!');
                    $('.btn_apply_coupon').parent().remove();
                } else {
                    toastr.error('Invalid coupon.');
                    $('.text_coupon').val('');
                }
            });
    </script>
    @endsection
