@extends('layouts.app')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
@endsection

@section('content')
    <section id="dashboard-analytics">
        <div class="row">
            @if(!($finished))
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card bg-analytics text-white">
                        <div class="card-content">
                            <div class="card-body text-center">
                                <div class="avatar avatar-xl bg-warning shadow mt-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-alert-triangle white font-large-1"></i>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <h1 class="mb-2 text-white">Hi {{ Auth::user()->name }} ,</h1>
                                    <p class="m-auto w-75">
                                        You have <strong>NOT</strong> completed your profile.<br>
                                        Complete your profile to benefits all of possibilities on this community.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/home.js')) }}"></script>
@endsection
