@extends('layouts.app')

@section('content')
    <div class="container-fluid bg-white mt-5">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box card">
                <div class="card-body">
                    <h3 class="box-title pull-left">StatesTax {{ $statestax->id }}</h3>
                    
                        <a class="btn btn-success pull-right" href="{{ url('/statetax/states-tax') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> Back</a>
                    
                    <div class="clearfix"></div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $statestax->id }}</td>
                            </tr>
                            <tr><th> Name </th><td> {{ $statestax->name }} </td></tr><tr><th> Code </th><td> {{ $statestax->code }} </td></tr><tr><th> Tax </th><td> {{ $statestax->tax }} </td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.admin.footer')
</div>
@endsection

