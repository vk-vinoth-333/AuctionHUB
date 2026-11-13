@extends('layouts.main')

@section('title')
    {{ __('teams') }}
@endsection


@section('content')

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('create_and_manage') . ' ' . __('teams') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('home') }}" class="text-dark">
                                <i class="fas fa-home mr-1"></i>{{ __('dashboard') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item active brand-red">
                            <i class="fas fa-users mr-1"></i>{{ __('teams') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @can('tournament-create')
                    <div class="col-md-12 d-flex justify-content-end">
                        <!-- <button id="toggleButton" class="btn btn-primary mb-3 ml-1"><i
                                                                                                        class="fas fa-plus-circle mr-2"></i></button> -->
                        <a href="{{ route('teams.create') }}" class="btn btn-primary mb-3 ml-1">
                            <i class="fas fa-plus-circle"></i> {{ __('create') . ' ' . __('team') }}
                        </a>
                    </div>
                @endcan
                @can('tournament-list')
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('teams') . ' ' . __('list') }}</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="teams_list_table" class="table table-bordered table-striped nowrap"
                                    style="width:100%">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('logo') }}</th>
                                            <th>{{ __('team_name') }}</th>
                                            <th>{{ __('short_name') }}</th>
                                            <th>{{ __('tournament') }}</th>
                                            <th>{{ __('owner') }}</th>
                                            <th>{{ __('phone') }}</th>
                                            <th>{{ __('status') }}</th>
                                            <th class="text-center">{{ __('actions') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($teams as $key => $team)

                                            <tr>

                                                <td>{{ $key + 1 }}</td>

                                                <td>
                                                    @if($team->logo)
                                                        <img src="{{ asset('storage/' . $team->logo) }}" width="40" height="40"
                                                            class="rounded">
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>

                                                <td>{{ $team->name }}</td>

                                                <td>{{ $team->short_name ?? '-' }}</td>

                                                <td>{{ $team->tournament->name ?? '-' }}</td>

                                                <td>{{ $team->owner_name ?? '-' }}</td>

                                                <td>{{ $team->contact_phone ?? '-' }}</td>

                                                <td>
                                                    @if($team->status)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">

                                                    <a href="{{ route('teams.show', $team->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST"
                                                        style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>

                                                    </form>

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </section>
@endsection

@section('script')

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            //data table
            new DataTable('#teams_list_table', {
                paging: true,
                searching: true,
                ordering: true,
                scrollX: true,
                language: {
                    emptyTable: "No teams found"
                }
            });

        });

    </script>

@endsection