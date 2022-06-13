@extends('layouts.auth')

@section('title', 'Registration')

@section('content')
    <div class='box'>
        <div class='box-form'>
            <div class='box-login-tab registration-tab'></div>
            <div class='box-login-title registration-title'>
                <div class='i i-login registration-text'></div><h2>REGISTRATION</h2>
            </div>
            <div class='box-login'>
                <div class='fieldset-body' id='login_form'>
                    <button onclick="openLoginInfo();" class='b b-form i i-more'></button>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <p class='field'>
                            <label for='user'>USERNAME</label>
                            <input type='text' id='user' name='username' required>
                            @include('frontend._partials._errors', ['error_name' => 'username'])
                        </p>

                        <p class='field'>
                            <label for='user'>E-MAIL</label>
                            <input type='text' id='user' name='email' required>
                            @include('frontend._partials._errors', ['error_name' => 'email'])
                        </p>
                        <p class='field'>
                            <label for='pass'>PASSWORD</label>
                            <input type='password' id='pass' name='password' title='Password' required>
                            @include('frontend._partials._errors', ['error_name' => 'password'])
                        </p>

                        <p class='field'>
                            <label for='pass'>PASSWORD CONFIRMATION</label>
                            <input type='password' id='pass' name='password_confirmation' title='Password' required>
                            @include('frontend._partials._errors', ['error_name' => 'password_confirmation'])
                        </p>

                        <input type='submit' id='do_login' value='SIGN UP' required>
                    </form>
                </div>
            </div>
        </div>
        <div class='box-info'>
            <p><button onclick="closeLoginInfo();" class='b b-info i i-left' title='Back to Sign In'></button></p>
            <a href="{{ route('login') }}" class="btn b-cta">LOG IN</a>
        </div>
    </div>
@endsection
