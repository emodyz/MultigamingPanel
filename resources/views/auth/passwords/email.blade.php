@extends('layouts.auth')

@section('auth.title')
    {{ __('Reset Password') }}
@endsection

@section('auth.subtitle')
    Lost your password ? Request a new one now.
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success mb-3" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
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

        <div class="pb-4 d-flex flex-column flex-sm-row justify-content-between">
            <a href="{{route('login')}}" class="btn btn-outline-primary float-left btn-inline mb-sm-0 mb-1">
                {{__('Login')}}
            </a>
            <button type="submit" class="btn btn-primary float-right btn-inline">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </form>
@endsection
