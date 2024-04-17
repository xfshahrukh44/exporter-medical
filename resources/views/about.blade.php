@extends('layouts.main')
@section('content')

            <div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
                <div class="custom-container">
                    <div class="breadcrumb-content text-center">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="active"> {{ $page->page_name }} </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="about-us-area fix about-us-img pt-65 pb-75">
                <div class="container">
                    <div class="section-title-2 mb-35 wow tmFadeInUp">
                        <h2>{{ $page->name }}</h2>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="about-us-img wow tmFadeInUp">
                                <img src="{{ asset($page->image) }}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-us-content wow tmFadeInUp">
                                {!! $page->content !!}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mouse-scroll-area-2" id="scene">
                    <div data-depth="0.3" class="layer about-us-shape-1">
                        <div class="medizin-shape"></div>
                    </div>
                </div>
            </div>
        
            <div class="contact-us-area contact-us-bg pt-75 pb-75">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-width-58 custom-common-column">
                            <div class="contact-from-area contact-from-area-bg padding-20-row-col wow tmFadeInUp">
                                <h3>Ask us anything here</h3>
                                <form class="contact-form-style" id="aboutform">
                                    @csrf

                                    <input type="hidden" name="form_name" value="About Page Form Submission">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="input-style mb-20">
                                                <input name="first_name" placeholder="First Name" type="text" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-style mb-20">
                                                <input name="last_name" placeholder="Last Name" type="text" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-style mb-20">
                                                <input name="phone" placeholder="Phone number" type="text" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-style mb-20">
                                                <input name="email" placeholder="Email" type="email" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input-style mb-20">
                                                <input name="extra_content" placeholder="How can we help you" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label for="">Please Enter Your Questions Below*</label>
                                            <div class="textarea-style mb-30">
                                                <textarea name="notes" placeholder="Your Questions"></textarea>
                                            </div>
                                            <button class="submit" type="submit">Send message</button>
                                        </div>
                                    </div>
                                </form>
                                <div id="aboutformresult" class="mt-5">

                                </div>
                            </div>
                        </div>
                        <div class="col-width-41 custom-common-column">
                            <div class="contact-info-wrap">
                                <div class="single-contact-info2-wrap wow tmFadeInUp">
                                    <div class="single-contact-info2-icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="single-contact-info2-content">
                                        <p>Call for help now!</p>
                                        <h2> <a href="tel:{{ App\Http\Traits\HelperTrait::returnFlag(59) }}">{{ App\Http\Traits\HelperTrait::returnFlag(59) }}</a></h2>
                                    </div>
                                </div>
                                <div class="single-contact-info2-wrap wow tmFadeInUp">
                                    <div class="single-contact-info2-icon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div class="single-contact-info2-content">
                                        <p>Say hello</p>
                                        <h3><a href="mailto:{{ App\Http\Traits\HelperTrait::returnFlag(218) }}">{{ App\Http\Traits\HelperTrait::returnFlag(218) }}</a></h3>
                                    </div>
                                </div>
                                <div class="single-contact-info2-wrap wow tmFadeInUp">
                                    <div class="single-contact-info2-icon">
                                        <i class="fa fa-map-marked-alt"></i>
                                    </div>
                                    <div class="single-contact-info2-content">
                                        <p>Address</p>
                                        <h4> <a href="#"> {!! App\Http\Traits\HelperTrait::returnFlag(519) !!}</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
