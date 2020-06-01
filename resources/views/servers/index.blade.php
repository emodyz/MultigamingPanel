@extends('layouts.app')


@section('css')
    <link rel="stylesheet" type="text/css" href="css/pages/servers/index.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/tables/datatable/datatables.min.css">
@endsection

@section('content')
    <section id="data-list-view" class="data-list-view-header">
        <div class="action-btns d-none">
            <div class="btn-dropdown mr-1 mb-1">
                <div class="btn-group dropdown actions-dropodown">
                    <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="feather icon-trash"></i>Delete</a>
                        <a class="dropdown-item" href="#"><i class="feather icon-archive"></i>Archive</a>
                        <a class="dropdown-item" href="#"><i class="feather icon-file"></i>Print</a>
                        <a class="dropdown-item" href="#"><i class="feather icon-save"></i>Another Action</a>
                    </div>
                </div>
            </div>
        </div>

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
                            <span class="action-edit">
                                <i class="feather icon-edit"></i>
                            </span>
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


@section('script')
    <script src="vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>

    <script src="js/pages/servers/index.js"></script>
@endsection
