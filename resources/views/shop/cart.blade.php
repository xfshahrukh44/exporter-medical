@extends('layouts.main')
@section('title', 'Cart')
@section('css')
    <style type="text/css">
        h4.servname {
            font-size: 16px !important;
        }
                a.checkout_css {
            color: #fff;
            -moz-border-radius: 3px;
            border-radius: 3px;
            text-transform: uppercase;
            background: #bd2323;
            font-family: 'Oswald', sans-serif;
        }

        .cart-table img {
            width: 100%;
        }

        .cart-table td {
            vertical-align: middle;
        }

        .cart-table h5 {
            font-size: 18px;
            line-height: 30px;
            margin-bottom: 0px;
        }

        .cart-table h4 {
            margin-bottom: 0px;
            font-size: 20px;
        }

        .cart-table tbody td:first-child {
            width: 50%;
        }


        .cart-table tbody td i {
            color: #c91d22;
        }

        .table-bordered thead th {
            background-color: white;
            color: black;
        }

        a.shopping {
            color: white;
            font-size: 18px;
        }

        input.qtystyle {
            text-align: center;
        }

        .check-out-detail {
            background-color: #bd2323;
            color: white;
            padding: 25px;
            padding-bottom: 2px;
            border-radius: 3px;
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
                    <li class="active">Shopping Cart</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="cart-area pt-75 pb-35">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form method="post" action="{{ route('update_cart') }}" id="update-cart">
                        {{ csrf_field() }}
                        <input type="hidden" name="type" id="type" value="">

                        <div class="cart-table-content">
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="width-thumbnail">Product</th>
                                            <th class="width-name"></th>
                                            <th class="width-price"> Price</th>
                                            <th class="width-quantity">Quantity</th>
                                            <th class="width-subtotal">Subtotal</th>
                                            <th class="width-remove"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $subtotal = 0;
                                        $addon_total = 0;
                                        $total_variation = 0;
                                        ?>
                                        @foreach ($cart as $key => $value)
                                            <?php
                                            $prod_image = App\Product::where('id', $value['id'])->first();
                                            ?>
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a
                                                        href="{{ route('shopDetail', ['id' => $prod_image->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $prod_image->product_title)))]) }}">
                                                        @if (@getimagesize($prod_image->image) != false)
                                                            <img src="{{ asset($prod_image->image) }}" alt="">
                                                        @else
                                                            <img src="{{ asset('uploads/products/no_image.jpg') }}"
                                                                alt="">
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="product-name">
                                                    <h5><a href="product-details.html">{{ $value['name'] }}</a></h5>
                                                </td>
                                                <td class="product-price"><span
                                                        class="amount">${{ $value['baseprice'] }}</span></td>
                                                <td class="cart-quality">
                                                    <div class="product-quality">
                                                        <input class="cart-plus-minus-box input-text qty text"
                                                            name="row[{{ $key }}]" value="{{ $value['qty'] }}">
                                                    </div>
                                                </td>
                                                <td class="product-total">
                                                    <span>${{ $value['baseprice'] * $value['qty'] + $value['variation_price'] }}</span>
                                                </td>
                                                <td class="product-remove"><a href="javascript:;"
                                                        onclick="window.location.href='{{ route('remove_cart', [$value['id']]) }}'">Remove</a>
                                                </td>
                                            </tr>
                                            <?php
                                            $subtotal += $value['baseprice'] * $value['qty'];
                                            $total_variation += $subtotal + $value['variation_price'];
                                            ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-shiping-update-wrapper">
                                <div class="continure-clear-btn">
                                    <div class="continure-btn">
                                        <a href="{{ route('home') }}">Continue shopping</a>
                                    </div>
                                    
                                    <!--<div class="clear-btn">
                                        <a href="{{ route('clear.cart') }}"><i class="fa fa-times"></i> Clear shopping
                                            cart</a>
                                    </div> -->
                                    
                                </div>
                                <div class="update-btn">
                                    <button type="submit">Update cart</button>
                                </div>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
          
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12">

                </div>

                <div class="col-lg-4 col-md-12 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                             <div class="grand-total-wrap mb-40">
                                <ul>
                                    <li>
                                        Subtotal
                                        <h4>${{ $subtotal }}</h4>
                                    </li>

                                </ul>
                                <div class="grand-total">
                                    <h4>Total <span>${{ $subtotal }}</span></h4>
                                </div>
                                <div class="grand-total-btn">
                                    <a href="{{ url('checkout') }}">Checkout</a>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script type="text/javascript">
        $(document).on('click', ".updateCart", function(e) {

            $('#type').val($(this).attr('data-attr'));
            $('#update-cart').submit();

        });

        $(document).on('keydown keyup', ".qtystyle", function(e) {
            if ($(this).val() <= 1) {
                e.preventDefault();
                $(this).val(1);
            }

        });
    </script>

    <script>
        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        $(document).on('click', ".addCoupon", function(e) {
            $('#addCoupon').submit();
        });


        $('input.qtystyle').on('input', function(e) {
            // alert('Changed!')
            // alert($(this).val());
            // alert($(this).attr('data-attr-stock'));

            if (parseInt($(this).val()) > parseInt($(this).attr('data-attr-stock'))) {
                $(this).val(parseInt($(this).attr('data-attr-stock')));
                generateNotification('danger', 'please select only available ' + parseInt($(this).attr(
                    'data-attr-stock')) + ' items in stock');
            }

        });
        // $(document).ready(function(IDofObject) {
        //     $(document).on('click', '.plus', function() {
        //         console.log(IDofObject);
        //         $('.count').val(parseInt($('.count').val()) + 1);
        //     });
        //     $(document).on('click', '.minus', function() {
        //         $('.count').val(parseInt($('.count').val()) - 1);
        //         if ($('.count').val() == 0) {
        //             $('.count').val(1);
        //         }
        //     });
        // });

        function change(IDofObject, sign) {
            if (sign == "+") {


                document.getElementById(('counter '.concat((IDofObject).toString()))).value = parseInt(document
                    .getElementById((
                        'counter '
                        .concat(
                            IDofObject.toString()))).value) + 1
            } else {
                if (parseInt(document
                        .getElementById((
                            'counter '
                            .concat(
                                IDofObject.toString()))).value) > 1) {

                    console.log(document.getElementById(('counter '.concat((IDofObject).toString()))).value)

                    document.getElementById(('counter '.concat((IDofObject).toString()))).value = parseInt(document
                        .getElementById((
                            'counter '
                            .concat(
                                IDofObject.toString()))).value) - 1
                }
            }
        }
    </script>

    <script>
        function myFunction() {
            alert("Please Calculate Shipping First!");
        }
    </script>

@endsection
