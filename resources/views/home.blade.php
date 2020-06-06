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
        <div class="row">
            <div class="col-xl-4 col-md-6 col-sm-12 profile-card-2">
                <div class="card" style="height: 929.188px;">
                    <div class="card-header mx-auto pb-0">
                        <div class="row m-0">
                            <div class="col-sm-12 text-center">
                                <h4>{{ Auth::user()->name }}</h4>
                            </div>
                            <div class="col-sm-12 text-center">
                                <p class="">Administrator</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body text-center mx-auto">
                            <div class="avatar avatar-xl">
                                <img class="img-fluid" src="images/portrait/small/avatar-s-12.jpg" alt="img placeholder">
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="uploads">
                                    <p class="font-weight-bold font-medium-2 mb-0">568</p>
                                    <span class="">Car</span>
                                </div>
                                <div class="followers">
                                    <p class="font-weight-bold font-medium-2 mb-0">78.6k</p>
                                    <span class="">Héli</span>
                                </div>
                                <div class="following">
                                    <p class="font-weight-bold font-medium-2 mb-0">112</p>
                                    <span class="">Permis</span>
                                </div>
                            </div>
                            <button class="btn gradient-light-primary btn-block mt-2 waves-effect waves-light">Your profile</button>
                            <hr class="my-2">
                            <div class="card collapse-icon accordion-icon-rotate">
                                <div class="card-body">
                                    <div class="accordion" id="accordionExample" data-toggle-hover="true">
                                        <div class="collapse-margin">
                                            <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="display: block">
                <span class="lead collapse-title collapsed">
                  <i class="feather icon-user"></i> Citizen
                </span>
                                            </div>

                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    Pastry pudding cookie toffee bonbon jujubes jujubes powder topping. Jelly beans gummi bears sweet roll
                                                    bonbon muffin liquorice. Wafer lollipop sesame snaps.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse-margin">
                                            <div class="card-header" id="headingTwo" data-toggle="collapse" role="button" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="display: block">
                <span class="lead collapse-title collapsed">
                  <i class="fa fa-shield"></i> PoliceMan
                </span>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    Sweet pie candy jelly. Sesame snaps biscuit sugar plum. Sweet roll topping fruitcake. Caramels
                                                    liquorice biscuit ice cream fruitcake cotton candy tart.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse-margin">
                                            <div class="card-header" id="headingThree" data-toggle="collapse" role="button" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="display: block">
                <span class="lead collapse-title">
                  <i class="fa fa-heartbeat"></i> Medic
                </span>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    Tart gummies dragée lollipop fruitcake pastry oat cake. Cookie jelly jelly macaroon icing jelly beans
                                                    soufflé cake sweet. Macaroon sesame snaps cheesecake tart cake sugar plum.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
