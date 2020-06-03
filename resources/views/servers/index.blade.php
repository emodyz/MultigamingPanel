@extends('layouts.app')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/pages/servers/index.css')) }}">
@endsection

@section('content')
    <section id="data-list-view" class="data-list-view-header">
        <!-- DataTable starts -->
        <div class="table-responsive">
            <table class="table data-list-view">
                <thead>
                <tr>
                    <th>NAME</th>
                    <th>GAME</th>
                    <th>POPULARITY</th>
                    <th>SERVER STATUS</th>
                    <th>ONLINE PLAYERS</th>
                    <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                @foreach($servers as $server)
                    <tr>
                        <td class="server-name">{{$server->name}}</td>
                        <td class="server-category">{{$server->game->name}}</td>
                        <td>
                            <span class="hidden">{{$server->status['popularity']}}</span>
                            @if($server->status['popularity'] < 10)
                                <div class="progress progress-bar-dark">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="40"
                                         aria-valuemax="100" style="width:{{$server->status['popularity']}}%"></div>
                                </div>
                            @elseif($server->status['popularity'] >= 10 && $server->status['popularity'] < 40)
                                <div class="progress progress-bar-danger">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="40"
                                         aria-valuemax="100" style="width:{{$server->status['popularity']}}%"></div>
                                </div>
                            @elseif($server->status['popularity'] >= 40 && $server->status['popularity'] < 70)
                                <div class="progress progress-bar-warning">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="40"
                                         aria-valuemax="100" style="width:{{$server->status['popularity']}}%"></div>
                                </div>
                            @else
                                <div class="progress progress-bar-success">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="40"
                                         aria-valuemax="100" style="width:{{$server->status['popularity']}}%"></div>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($server->status['online'] === true)
                                <div class="chip chip-success">
                                    <div class="chip-body">
                                        <div class="chip-text">ONLINE</div>
                                    </div>
                                </div>
                            @else
                                <div class="chip chip-danger">
                                    <div class="chip-body">
                                        <div class="chip-text">OFFLINE</div>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td class="server-price">{{ $server->status['players']['online'] }}</td>
                        <td class="server-action">
                            <a href="{{route('servers.edit', [$server->id])}}" class="action-edit">
                                <i class="feather icon-edit"></i>
                            </a>
                            <span class="action-delete">
                                <i class="feather icon-trash"></i>
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- DataTable ends -->
    </section>
@endsection


@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/pages/servers/index.js')) }}"></script>
@endsection
