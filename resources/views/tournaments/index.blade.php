@extends('layouts.main')

@section('title')
    {{ __('tournaments') }}
@endsection


@section('content')

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('create_and_manage') . ' ' . __('tournaments') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('home') }}" class="text-dark"><i
                                    class="fas fa-home mr-1"></i>{{ __('dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active brand-red"><i
                                class="nav-icon fas fa-newspaper mr-1"></i>{{ __('tournaments') }}
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
                        <a href="{{ route('tournaments.create') }}" class="btn btn-primary mb-3 ml-1">
                            <i class="fas fa-plus-circle"></i> {{ __('create') . ' ' . __('tournament') }}
                        </a>
                    </div>
                @endcan
                @can('tournament-list')
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('tournaments') . ' ' . __('list') }}</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="tournaments_list_table" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Logo</th>
                                            <th>Name</th>
                                            <th>Short Code</th>
                                            <th>Venue & City</th>
                                            <th>From - To</th>
                                            <th>Prize Amount</th>
                                            <th>Player Registration Amount</th>
                                            <th>Status</th>
                                            <th>Organizer</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tournaments as $tournament)
                                            <tr>

                                                <td>
                                                    @if ($tournament->logo)
                                                        <img src="{{ asset('storage/' . $tournament->logo) }}" width="50"
                                                            height="50" style="object-fit:cover;border-radius:6px;">
                                                    @else
                                                        <span class="text-muted">No logo</span>
                                                    @endif
                                                </td>

                                                <td>{{ $tournament->name }}</td>

                                                <td>{{ $tournament->short_code }}</td>

                                                <td>{{ $tournament->venue }}{{ $tournament->city ? ', ' . $tournament->city : '' }}
                                                </td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($tournament->start_date)->format('d F, Y') }}
                                                    —
                                                    {{ $tournament->end_date ? \Carbon\Carbon::parse($tournament->end_date)->format('d F, Y') : 'N/A' }}
                                                </td>

                                                <td>₹ {{ number_format($tournament->prize_amount, 0, '.', ',') }}</td>

                                                <td>
                                                    @if ($tournament->is_pr_free)
                                                        <span class="badge bg-success">Free</span>
                                                    @else
                                                        ₹ {{ number_format($tournament->pr_amount, 0, '.', ',') }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($tournament->status)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                @php
                                                    $organizer_name = App\Models\Admin::where(
                                                        'id',
                                                        $tournament->organizer_id,
                                                    )->first();
                                                @endphp
                                                <td>{{ $organizer_name->username ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('tournaments.show', $tournament->id) }}"
                                                        class="btn btn-sm btn-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('tournaments.auction', $tournament->id) }}"
                                                        class="btn btn-sm btn-warning" title="Auction">
                                                        <i class="fas fa-gavel"></i> Auction
                                                    </a>

                                                    <a href="{{ route('tournaments.edit', $tournament->id) }}"
                                                        class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('tournaments.destroy', $tournament->id) }}"
                                                        method="POST" style="display:inline-block"
                                                        onsubmit="return confirm('Are you sure to delete?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>


                                            </tr>

                                        @empty
                                        @endforelse
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
        document.addEventListener('DOMContentLoaded', function() {

            new DataTable('#tournaments_list_table', {
                paging: true,
                searching: true,
                ordering: true,
                scrollX: true,
                language: {
                    emptyTable: "No tournaments found"
                }
            });

        });
    </script>
@endsection
