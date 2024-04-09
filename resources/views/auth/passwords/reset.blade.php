 @extends('layouts.main')

@section('content')

  

    <div class="container mt-50 mb-50">
        <div class="page-wrapper m-0 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-12">
                        <div class="card border-0">
                            
                                <form method="POST" class="form bordered-input" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">


                                    <div class="p-30 pb-0">
                                        <h3>Reset Password</h3>

                                        <div class="form-group mt-15 row">
                                            <div class="col-12 input-style">
                                                <label >Email Address</label>
                                                <input class="form-control pl-0 font-12 {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="Email" name="email" >
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row mt-15">
                                            <div class="col-12 input-style">
                                                <label >Password</label>
                                                <input class="form-control  pl-0 font-12 {{ $errors->has('password') ? ' is-invalid' : '' }}"  type="password" name="password" placeholder="password" >
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row mt-15">
                                            <div class="col-12 input-style">
                                                <label >Confirm Password</label>

                                                <input id="password-confirm" type="password" class="form-control  pl-0 font-12" name="password_confirmation"  placeholder="Confirm password" >
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group row mb-10">
                                            <div class="col-12">
                                                <p class="text-center"><button type="submit" class="btn-style-1">Reset Password</button></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            
                        </div>
                        <div class="clearfix"></div>
                        <div class="text-center mt-5">
                            <ul class="social-network social-circle">
                                <li><a href="#" class="icoFacebook" title="Facebook"><i class="mdi mdi-facebook"></i></a></li>
                                <li><a href="#" class="icoTwitter" title="Twitter"><i class="mdi mdi-twitter"></i> </a></li>
                                <li><a href="#" class="icoGoogle" title="Google +"><i class="mdi mdi-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('css')
<style>
    h3 {
        text-align: center;
        font-weight: 500;
        font-size: 29px;
        margin-bottom: 20px;
    }
    label {
        margin-bottom: 12px;
    }
    button.btn-style-1 {
        display: inline-block;
        color: #ffffff;
        font-size: 15px;
        font-weight: bold;
        border-radius: 50px;
        padding: 14px 42px 16px;
        background-color: #4e97fd;
        border: 0;
        margin-top: 20px;
        width: 50%;
        text-align: center;
    }


</style>
@endsection
@endsection
