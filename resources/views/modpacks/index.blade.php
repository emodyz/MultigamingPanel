@extends('layouts.app')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/pages/modpacks/index.css')) }}">

    <!-- MODAL REQUIRED -->
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/wizard.css')) }}">
@endsection

@section('content')
    <section id="data-list-view" class="data-list-view-header">

        <create-modpack id="createModpackModal"></create-modpack>

        <!-- DataTable starts -->
        <div class="table-responsive">
            <table class="table data-list-view">
                <thead>
                <tr>
                    <th>NAME</th>
                    <th>LOCAL PATH</th>
                    <th>SERVERS</th>
                    <th>LAST UPDATE</th>
                    <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                @foreach($modpacks as $modpack)
                    <tr>
                        <td class="server-name">{{$modpack->name}}</td>
                        <td class="server-category">{{$modpack->path}}</td>
                        <td class="server-price">{{ $modpack->servers->count() }}</td>
                        <td class="server-category">{{$modpack->manifest_last_update}}</td>
                        <td class="server-action">
                            <a href="{{route('modpacks.edit', [$modpack->id])}}" class="action-edit">
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

    <!-- MODAL REQUIRED -->
    <script src="{{ asset(mix('vendors/js/extensions/jquery.steps.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/pages/modpacks/index.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/modal/components-modal.js')) }}"></script>

    <!-- MODAL REQUIRED -->
    <script src="{{ asset(mix('js/scripts/forms/wizard-steps.js')) }}"></script>
@endsection

