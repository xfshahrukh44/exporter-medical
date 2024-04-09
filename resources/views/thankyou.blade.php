@extends('layouts.main')
@section('content')
   <div class="contanier">
    <div class="row">
        <div class="col-md-12">
            <div class="centercontent">
                <h1>THANK YOU</h1>
                <i class="fa fa-check" id="checkmark"></i>
                <p>You will receive an invoice via email..</p>
                <p> Go Back to <a href="">Home Page</a></p>
            </div>

        </div>
    </div>
   </div>


@endsection
@section('css')
<style>
.centercontent {
    display: flex;
    justify-content: center;
    flex-direction: column;
    text-align: center;
    align-items: center;
    margin: 45px 0;
}
.centercontent h1 {
    font-family: 'Manrope';
    font-size: 6.25rem;
    font-weight: 900;
}
.centercontent i {
    font-size: 9.75rem;
    font-weight: 900;
    color: #24b663;
}
.centercontent p {
    font-size: 16px;
    font-weight: 900;
    margin-top: 14px;
    width: 50%;
    
    font-style: italic;
}
</style>
@endsection

@section('js')
<script type="text/javascript"></script>
@endsection
