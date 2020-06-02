@extends('layouts.auth')

@section('auth.title')
    {{__('Login')}}
@endsection

@section('auth.subtitle')
    Welcome back, please login to your account.
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
@endsection

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <fieldset class="form-label-group form-group position-relative has-icon-left">

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   name="email" placeholder="E-Mail Address" value="{{ old('email') }}" required autocomplete="email"
                   autofocus>


            <label for="email">E-Mail Address</label>
            <div class="form-control-position">
                <i class="feather icon-user"></i>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </fieldset>

        <fieldset class="form-label-group position-relative has-icon-left">

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   name="password" placeholder="Password" required autocomplete="current-password">

            <div class="form-control-position">
                <i class="feather icon-lock"></i>
            </div>
            <label for="password">Password</label>
            @error('password')
            <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </fieldset>
        <div class="form-group d-flex justify-content-between align-items-center">
            <div class="text-left">
                <fieldset class="checkbox">
                    <div class="vs-checkbox-con vs-checkbox-primary">
                        <input type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <span class="vs-checkbox">
                            <span class="vs-checkbox--check">
                              <i class="vs-icon feather icon-check"></i>
                            </span>
                          </span>
                        <span class="">Remember me</span>
                    </div>
                </fieldset>
            </div>
            @if (Route::has('password.request'))
                <div class="text-right"><a class="card-link" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a></div>
            @endif

        </div>
        <a href="register" class="btn btn-outline-primary float-left btn-inline">Register</a>
        <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
    </form>
@endsection
