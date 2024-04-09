@section('title','Register')
@extends('layouts.main')
@section('css')
<style>
    button.btn.btn-yellow {
    background: #ffa859;
    color: #fff;
    width: 100%;
    font-size: 20px;
}
section.account {
    padding: 70px 0px;
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
                <li class="active">login / register </li>
            </ul>
        </div>
    </div>
</div>

<div class="login-register-area pt-75 pb-75">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login-register-wrap login-register-gray-bg">
                    <div class="login-register-title">
                        <h1>Login</h1>
                    </div>
                    <div class="login-register-form">
                        <form method="POST" action="{{ route('login') }}">
                             @csrf
                            <div class="login-register-input-style input-style input-style-white">
                                <label>Email Address *</label>
                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="login-register-input-style input-style input-style-white">
                                <label>Password *</label>
                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                @if ($errors->has('password'))
                                <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                            <div class="lost-remember-wrap">
                                <div class="remember-wrap">
                                    <input type="checkbox">
                                    <span>Remember me</span>
                                </div>
                                <div class="lost-wrap">
                                    <a href="{{ url('password/reset') }}">Lost your password?</a>
                                </div>
                            </div>
                            <div class="login-register-btn">
                                <button type="submit">Log in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login-register-wrap">
                    <div class="login-register-title">
                        <h1>Register</h1>
                    </div>
                    <div class="login-register-form">
                        <form method="POST" action="{{ route('register') }}">
                             @csrf
                            <div class="login-register-input-style input-style">
                                <label>Username *</label>
                                <input type="text" class="form-control {{ $errors->registerForm->has('name') ? ' is-invalid' : '' }}" name="name" id="name"required>
                                @if ($errors->registerForm->has('name'))
                                <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->registerForm->registerForm->first('name') }}</small>
                                @endif
                            </div>
                            <div class="login-register-input-style input-style">
                                <label>Email address *</label>
                                <input type="email" class="form-control {{ $errors->registerForm->has('email') ? ' is-invalid' : '' }}" name="email" id="signup-email" required>
                                @if ($errors->registerForm->has('email'))
                                <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->registerForm->first('email') }}</small>
                                @endif
                            </div>
                            <div class="login-register-input-style input-style">
                                <label>Password *</label>
                                <input type="password" class="form-control {{ $errors->registerForm->has('password') ? ' is-invalid' : '' }}" name="password" id="signup-password" required>
                                @if ($errors->registerForm->has('password'))
                                <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->registerForm->first('password') }}</small>
                                @endif
                            </div>
                            <div class="login-register-input-style input-style">
                                <label>Confirm Password *</label>
                                <input type="password" class="form-control" name="password_confirmation" id="signup-password" required>
                                @if ($errors->registerForm->has('password_confirmation'))
                                <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->registerForm->first('password_confirmation') }}</small>
                                @endif
                            </div>
                            <div class="privacy-policy-wrap">
                                <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#">privacy policy</a></p>
                            </div>
                            <div class="login-register-btn">
                                <button type="submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
<script>
    $("#phone").on("keypress keyup blur",function (event) {
       $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
</script>
@endsection
