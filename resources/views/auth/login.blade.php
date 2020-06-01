@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <fieldset class="form-label-group form-group position-relative has-icon-left">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                   value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="form-control-position">
                <i class="feather icon-user"></i>
            </div>
            <label for="email">{{ __('E-Mail Address') }}</label>
        </fieldset>

        <fieldset class="form-label-group position-relative has-icon-left">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="current-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror

            <div class="form-control-position">
                <i class="feather icon-lock"></i>
            </div>
            <label for="password">{{ __('Password') }}</label>
        </fieldset>
        <div class="form-group d-flex justify-content-between align-items-center">
            <div class="text-left">
                <fieldset class="checkbox">
                    <div class="vs-checkbox-con vs-checkbox-primary">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="vs-checkbox">
                            <span class="vs-checkbox--check">
                                <i class="vs-icon feather icon-check"></i>
                            </span>
                        </span>
                        <span class="">{{ __('Remember Me') }}</span>
                    </div>
                </fieldset>
            </div>
            @if (Route::has('password.request'))
                <div class="text-right">
                    <a class="card-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif
        </div>
        <a href="/register" class="btn btn-outline-primary float-left btn-inline">Register</a>
        <button type="submit" class="btn btn-primary float-right btn-inline">
            {{ __('Login') }}
        </button>

    </form>
@endsection
