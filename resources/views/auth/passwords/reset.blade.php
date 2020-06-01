@extends('layouts.auth')

@section('auth.title')
    {{ __('Reset Password') }}
@endsection

@section('content')

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <fieldset class="form-label-group form-group position-relative has-icon-left">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                   value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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

        <fieldset class="form-label-group form-group position-relative has-icon-left">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="new-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <div class="form-control-position">
                <i class="feather icon-lock"></i>
            </div>
            <label for="email">{{ __('Password') }}</label>
        </fieldset>

        <fieldset class="form-label-group form-group position-relative has-icon-left">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                   autocomplete="new-password">
            <div class="form-control-position">
                <i class="feather icon-lock"></i>
            </div>
            <label for="email">{{ __('Confirm Password') }}</label>
        </fieldset>

        <div class="pb-4">
            <a href="{{route('login')}}" class="btn btn-outline-primary float-left btn-inline">{{__('Login')}}</a>
            <button type="submit" class="btn btn-primary float-right btn-inline">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
@endsection
