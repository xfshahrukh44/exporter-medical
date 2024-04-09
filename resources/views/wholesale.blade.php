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

<!--big card section start-->

<section class="big-card">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="big-card-content">
                    <div class="card myCard">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-content-para1">
                                        <p>
                                            {!! $section[0]->value  !!}
                                        </p>
                                    </div>
                                </div>

                                {!! $section[1]->value  !!}

                                <div class="col-lg-12">
                                    <div class="card-content-img" data-aos="fade-down">
                                        <img src=" {!! $section[2]->value  !!}" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--big card section end-->

<!--small cars section start-->

<section class="small-cards">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="small-cards-content1" data-aos="fade-up">
                    <div class="image">
                        <img src="{!! $section[3]->value  !!}" alt="">
                    </div>

                    <div class="small-cards-para">
                        <p>
                            {!! $section[4]->value  !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="small-cards-content2" data-aos="fade-up">
                    <div class="image">
                        <img src="{!! $section[5]->value  !!}" alt="">
                    </div>

                    <div class="small-cards-para">
                        <p>
                            {!! $section[6]->value  !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="small-cards-content3" data-aos="fade-up">
                    <div class="image">
                        <img src="{!! $section[7]->value  !!}" alt="">
                    </div>

                    <div class="small-cards-para">
                        <p>
                            {!! $section[8]->value  !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--small cars section end-->














@endsection
@section('css')
<style>

</style>
@endsection

@section('js')
<script type="text/javascript"></script>
@endsection
