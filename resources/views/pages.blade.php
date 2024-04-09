@extends('layouts.main')
@section('content')


            <div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
                <div class="custom-container">
                    <div class="breadcrumb-content text-center">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="active">{{ $pages->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="privacy-policy-area pt-75 pb-35">
                <div class="container">
                    <div class="row flex-row-reverse">
                        <div class="col-lg-12">
                            <div class="medizin-common-style-wrap">
                                {!! $pages->content !!}
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