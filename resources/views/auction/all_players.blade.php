@extends('layouts.main')

@section('title')
    {{ __('players') }} - {{ $tournament->name }}
@endsection


@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('players') . ' ' . __('list') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('home') }}" class="text-dark"><i
                                    class="fas fa-home mr-1"></i>{{ __('dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ url('tournaments') }}" class="text-dark"><i
                                    class="nav-icon fas fa-newspaper mr-1"></i>{{ __('tournaments') }}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('tournaments.auction', $tournament->id) }}" class="text-dark"><i
                                    class="nav-icon fas fa-gavel mr-1"></i>{{ __('auction') }}</a>
                        </li>
                        <li class="breadcrumb-item active"><i
                                class="nav-icon fas fa-user-friends mr-1"></i>{{ __('players') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end mb-3">
                    <a href="{{ route('tournaments.auction', $tournament->id) }}" class="btn btn-primary mb-3 ml-1">
                        <i class="fas fa-arrow-left"></i> {{ __('back') }} to {{ __('auction') }}
                    </a>
                </div>

                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $tournament->name }} ({{ $tournament->short_code }}) -
                                {{ __('players') }}</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="players_list_table" class="table table-bordered table-striped nowrap"
                                style="width:100%">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('photo') }}</th>
                                        <th>{{ __('player_name') }}</th>
                                        <th>{{ __('number') }}</th>
                                        <th>{{ __('team') }}</th>
                                        <th>{{ __('role') }}</th>
                                        <th>{{ __('batting_style') }}</th>
                                        <th>{{ __('bowling_style') }}</th>
                                        <th>{{ __('base_price') }}</th>
                                        <th>{{ __('sold_price') }}</th>
                                        <th>{{ __('player_status') }}</th>
                                        <th>{{ __('payment_status') }}</th>
                                        <th class="text-center">{{ __('actions') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($players as $key => $player)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>
                                                @if ($player->photo)
                                                    <img src="{{ asset('storage/' . $player->photo) }}" width="40"
                                                        height="40" class="rounded player-media-thumb"
                                                        style="cursor:pointer"
                                                        data-img="{{ asset('storage/' . $player->photo) }}"
                                                        data-title="{{ $player->name }} - {{ __('photo') }}"
                                                        data-toggle="modal" data-target="#mediaViewerModal">
                                                @else
                                                    <div class="team-avatar"
                                                        style="width: 40px; height: 40px; font-size: 14px;">
                                                        {{ strtoupper(substr($player->name, 0, 2)) }}
                                                    </div>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="font-weight-bold text-dark">{{ $player->name }}</span>
                                            </td>

                                            <td>{{ $player->player_number ?? '-' }}</td>

                                            <td>
                                                @if ($player->team)
                                                    <span
                                                        class="badge badge-light border text-dark px-2 py-1">{{ $player->team->name }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <td>{{ $player->detail->role_label ?? '-' }}</td>

                                            <td>
                                                @php $battingStyle = $player->detail->batting_style ?? null; @endphp
                                                @if ($battingStyle === 'right_handed')
                                                    {{ __('right_handed') }}
                                                @elseif ($battingStyle === 'left_handed')
                                                    {{ __('left_handed') }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td>
                                                @php $bowlingStyle = $player->detail->bowling_style ?? null; @endphp
                                                @if ($bowlingStyle === 'right')
                                                    {{ __('right') }}
                                                @elseif ($bowlingStyle === 'left')
                                                    {{ __('left') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>
                                                @if ($player->detail->base_price ?? null)
                                                    ₹ {{ number_format((float) $player->detail->base_price) }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td>
                                                @if ($player->sold_out_points ?? null)
                                                    <span class="font-weight-bold" style="color: #dd6b20;">
                                                        ₹ {{ number_format((float) $player->sold_out_points) }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td>
                                                @if (($player->player_status ?? null) === 'sold')
                                                    <span class="badge badge-success">{{ __('sold') }}</span>
                                                @elseif (($player->player_status ?? null) === 'unsold')
                                                    <span class="badge badge-danger">{{ __('unsold') }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ __('pending') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if (($player->payment_status ?? null) === 'paid')
                                                    <span class="badge badge-success">{{ __('paid') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('not_paid') }}</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('players.show', $player->id) }}"
                                                    class="btn btn-sm btn-primary" title="{{ __('view') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="mediaViewerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediaViewerModalLabel">{{ __('preview') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="mediaViewerImage" class="img-fluid" alt="preview">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .team-avatar {
            background: #f3f4f6;
            color: #000;
            border: 2px solid #f3c9cc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            border-radius: 50%;
        }
    </style>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            new DataTable('#players_list_table', {
                paging: true,
                searching: true,
                ordering: true,
                scrollX: true,
                pageLength: 10,
                language: {
                    emptyTable: "{{ __('could_not_find_data') }}"
                }
            });

            $(document).on('click', '[data-toggle="modal"][data-target="#mediaViewerModal"]', function() {
                $('#mediaViewerImage').attr('src', $(this).data('img'));
                $('#mediaViewerModalLabel').text($(this).data('title') || '{{ __('preview') }}');
            });

        });
    </script>
@endsection
