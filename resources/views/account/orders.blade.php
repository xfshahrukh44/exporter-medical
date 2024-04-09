@extends('layouts.main')
@section('title', 'Order')
@section('content')

<?php $segment = Request::segments(); ?>


<section class="innerBanner" style="background-position: center center;">
    <div class="custom-container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="active">Orders</li>
                    </ul>
                </div>
            </div>
</section>


<main class="my-cart">
  
 <!-- my account wrapper start -->
    <div class="my-account-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            @include('account.sidebar')
                            <!-- My Account Tab Menu End -->
    
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                   
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="orders" role="#">
                                        <div class="myaccount-content">
                                            <div class="section-heading">
                                                <h2>Orders</h2>
                                            </div>
    
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Invoice Number</th>
                                                            <th>Date</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
    
                                                    <tbody>
                                                    
                                                    @if($ORDERS)
                                                        @foreach($ORDERS as $ORDER)
                                                            <tr>
                                                              <td>{{ $ORDER->id }}</td>
                                                             
                                                              <td>{{ $ORDER->invoice_number }}</td>
                                                              <td>{{date('d F, Y h:i a',strtotime($ORDER->created_at))}}</td>
                                                              <td>${{ $ORDER->order_total  }}</td>
                                                              <td class="viewbtn"><a href="{{ route('invoice',[$ORDER->id]) }}">View</a></td>
                                                              
                                                            </tr>
                                                        @endforeach
                                                    @endif
                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
    
                                    
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->


<!-- main content end -->   
</main
>

@endsection
@section('css')
<style type="text/css">
        .myaccount-tab-menu.nav .active, .myaccount-tab-menu.nav a:hover {
        background-color: #4e97fd !important;
        border-color: #4e97fd !important;
        color: #ffffff !important;
    }
    
    .myaccount-tab-menu.nav a {
        border: 1px solid #eee !important;
        border-bottom: none !important;
        font-weight: 500 !important;
        font-size: 16px !important;
        display: block !important;
        color: #444 !important;
        padding: 15px 30px !important;
        text-transform: capitalize !important;
    }
    
    .myaccount-tab-menu.nav {
    border: 1px solid #eee !important;
    }
    
    .my-account-wrapper {
    padding: 100px 0px;
    }
    
    section.innerBanner {
    padding: 20px 0 20px;
    background-color: #f8f8f8;
    }
</style>
@endsection
@section('js')
<script type="text/javascript">
     $(document).on('click', ".btn1", function(e){
            // alert('it works');
            $('.loginForm').submit();
     });
</script>
@endsection