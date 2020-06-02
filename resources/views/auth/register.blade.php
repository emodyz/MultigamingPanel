@extends('layouts.auth')

@section('auth.title')
    {{__('Register')}}
@endsection

@section('auth.subtitle')
    Welcome ! Register now to see what append
@endsection

@section('content')

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <fieldset class="form-label-group form-group position-relative has-icon-left">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                   value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <div class="form-control-position">
                <i class="feather icon-tag"></i>
            </div>
            <label for="name">{{ __('Name') }}</label>
        </fieldset>

        <fieldset class="form-label-group form-group position-relative has-icon-left">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                   value="{{ old('email') }}" required autocomplete="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <div class="form-control-position">
                <i class="feather icon-user"></i>
            </div>
            <label for="name">{{ __('E-Mail Address') }}</label>
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
            <label for="name">{{ __('Password') }}</label>
        </fieldset>

        <fieldset class="form-label-group form-group position-relative has-icon-left">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                   autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="form-control-position">
                <i class="feather icon-lock"></i>
            </div>
            <label for="name">{{ __('Confirm Password') }}</label>
        </fieldset>

        <div class="form-group row">
            <div class="col-12">
                <fieldset class="checkbox">
                    <div class="vs-checkbox-con vs-checkbox-primary">
                        <input type="checkbox" checked>
                        <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                  <i class="vs-icon feather icon-check"></i>
                                                </span>
                                              </span>
                        <span class=""> I accept the terms & conditions.</span>
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="pb-4 d-flex flex-column flex-sm-row justify-content-between">
            <a href="{{route('login')}}" class="btn btn-outline-primary float-left btn-inline mb-sm-0 mb-1">
                {{__('Login')}}
            </a>
            <button type="submit" class="btn btn-primary float-right btn-inline">
                {{ __('Register') }}
            </button>
        </div>
    </form>
@endsection
