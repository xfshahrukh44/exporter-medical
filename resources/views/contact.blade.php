
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
                            <li class="active">{{ $page->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="contact-us-area pt-65 pb-55">
                <div class="container">
                    <div class="section-title-2 mb-45 wow tmFadeInUp">
                        {!! $page->content !!}
                    </div>
                    <div class="contact-info-wrap-2 mb-40">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12 col-sm-5 wow tmFadeInUp">
                                <div class="single-contact-info3-wrap mb-30">
                                    <div class="single-contact-info3-icon">
                                        <i class="fa fa-map-marker-alt"></i>
                                    </div>
                                    <div class="single-contact-info3-content">
                                        <h3>Address</h3>
                                        <p class="w-100">{!! App\Http\Traits\HelperTrait::returnFlag(519) !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 col-sm-7 wow tmFadeInUp">
                                <div class="single-contact-info3-wrap mb-30">
                                    <div class="single-contact-info3-icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="single-contact-info3-content">
                                        <h3>Contact</h3>
                                        <p> Mobile: <span>{{ App\Http\Traits\HelperTrait::returnFlag(59) }}</span></p>
                                        <p> Mail: <span>{{ App\Http\Traits\HelperTrait::returnFlag(218) }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 col-sm-12 wow tmFadeInUp">
                                <div class="single-contact-info3-wrap mb-30">
                                    <div class="single-contact-info3-icon">
                                        <i class="fa fa-clock"></i>
                                    </div>
                                    <div class="single-contact-info3-content">
                                        <h3>Hour of operation</h3>
                                        <p> {{ App\Http\Traits\HelperTrait::returnFlag(1972) }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-map pb-70">
                        <div id="map">
                            {!! App\Http\Traits\HelperTrait::returnFlag(1966) !!}
                        </div>
                    </div>
                    <!--<div class="row">-->
                    <!--    <div class="col-xl-8 col-lg-10 ml-auto mr-auto">-->
                    <!--        <div class="contact-from-area  padding-20-row-col wow tmFadeInUp">-->
                    <!--            <h3>Ask us anything here</h3>-->
                    <!--            <form class="contact-form-style text-center" id="contactform">-->
                    <!--                @csrf-->

                    <!--                <input type="hidden" name="form_name" value="Contact Form Submission">-->
                    <!--                <div class="row">-->
                    <!--                    <div class="col-lg-6 col-md-6">-->
                    <!--                        <div class="input-style mb-20">-->
                    <!--                            <input name="fname" placeholder="First Name" type="text">-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="col-lg-6 col-md-6">-->
                    <!--                        <div class="input-style mb-20">-->
                    <!--                            <input name="email" placeholder="Your Email" type="email">-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="col-lg-6 col-md-6">-->
                    <!--                        <div class="input-style mb-20">-->
                    <!--                            <input name="phone" placeholder="Your Phone" type="tel">-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="col-lg-6 col-md-6">-->
                    <!--                        <div class="input-style mb-20">-->
                    <!--                            <input name="extra_content" placeholder="Subject" type="text">-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="col-lg-12 col-md-12">-->
                    <!--                        <div class="textarea-style mb-30">-->
                    <!--                            <textarea name="notes" placeholder="Message"></textarea>-->
                    <!--                        </div>-->
                    <!--                        <button class="submit submit-auto-width" type="submit">Send message</button>-->
                    <!--                    </div>-->
                    <!--                </div>-->
                    <!--            </form>-->
                    <!--            <div id="contactformsresult" class="mt-5">-->

                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>

@endsection
@section('css')
<style>

</style>
@endsection

@section('js')
<script type="text/javascript"></script>
@endsection
