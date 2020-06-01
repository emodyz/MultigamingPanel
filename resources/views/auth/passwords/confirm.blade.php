@extends('layouts.auth')

@section('auth.title')
    {{ __('Confirm Password') }}
@endsection

@section('auth.subtitle')
    {{ __('Please confirm your password before continuing.') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <fieldset class="form-label-group form-group position-relative has-icon-left">
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror" name="password"
                   required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="form-control-position">
                <i class="feather icon-user"></i>
            </div>
            <label for="email">{{ __('Password') }}</label>
        </fieldset>

        <div class="pb-4 d-flex flex-column flex-sm-row justify-content-between">
            @if (Route::has('password.request'))
                <a href="{{route('password.request')}}" class="btn btn-link">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
            <button type="submit" class="btn btn-primary float-right btn-inline mb-sm-0 mb-1">
                {{ __('Confirm Password') }}
            </button>
        </div>
    </form>
@endsection
