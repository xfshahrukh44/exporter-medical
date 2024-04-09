@extends('layouts.main')
@section('title', 'Account')
@section('css')
<style>
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
@section('content')

<?php $segment = Request::segments(); ?>

<section class="innerBanner" style="background-position: center center;">
    <div class="custom-container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="active">My Account</li>
                    </ul>
                </div>
            </div>
</section>



<main class="my-cart">
    <div class="my-account-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="myaccount-page-wrapper">
                        <div class="row">
                            @include('account.sidebar')
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="dashboad">
                                        <div class="myaccount-content">
                                            <div class="section-heading">
                                                <h2>Dashboard</h2>

                                                <div class="welcome">

                                                    <p>Hello, <strong>{{ Auth::user()->name }}</strong> (If Not <strong>{{ Auth::user()->name }} !</strong><a href="{{ url('logout') }}" class="logout"> Logout</a>)</p>
                                                </div>

                                                <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
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
</main>

@endsection
@section('js')
<script type="text/javascript">
     $(document).on('click', ".btn1", function(e){
            // alert('it works');
            $('.loginForm').submit();
     });
</script>
@endsection
