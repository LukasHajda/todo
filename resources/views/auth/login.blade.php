@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class='box'>
    <div class='box-form'>
        <div class='box-login-tab'></div>
        <div class='box-login-title'>
            <div class='i i-login'></div><h2 class="login-text">LOGIN</h2>
        </div>
        <div class='box-login'>
            <div class='fieldset-body' id='login_form'>
                <button onclick="openLoginInfo();" class='b b-form i i-more'></button>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <p class='field'>
                        <label for='user'>E-MAIL</label>
                        <input type='text' id='user' name='email' required>
                        @include('frontend._partials._auth_errors', ['error_name' => 'email'])
                    </p>
                    <p class='field'>
                        <label for='pass'>PASSWORD</label>
                        <input type='password' id='pass' name='password' title='Password' required>
                        @include('frontend._partials._auth_errors', ['error_name' => 'password'])
                    </p>

                    <input type='submit' id='do_login' value='GET STARTED' required>
                </form>
            </div>
        </div>
    </div>
    <div class='box-info'>
        <p><button onclick="closeLoginInfo();" class='b b-info i i-left' title='Back to Sign In'></button></p>
        <a href="{{ route('register') }}" class="btn b-cta">CREATE ACCOUNT</a>
    </div>
</div>
@endsection
