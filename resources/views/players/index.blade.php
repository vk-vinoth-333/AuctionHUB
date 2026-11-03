@extends('layouts.main')

@section('title')
    {{ __('players') }}
@endsection


@section('content')

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('create_and_manage') . ' ' . __('players') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('home') }}" class="text-dark"><i
                                    class="fas fa-home mr-1"></i>{{ __('dashboard') }}</a>
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
                @can('player-create')
                    <div class="col-md-12 d-flex justify-content-end">
                        <a href="{{ route('players.create') }}" class="btn btn-primary mb-3 ml-1">
                            <i class="fas fa-plus-circle"></i> {{ __('create') . ' ' . __('player') }}
                        </a>
                    </div>
                @endcan

                @can('player-list')
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('players') . ' ' . __('list') }}</h3>
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
                                            <th>{{ __('tournament') }}</th>
                                            <th>{{ __('role') }}</th>
                                            <th>{{ __('batting_style') }}</th>
                                            <th>{{ __('bowling_style') }}</th>
                                            <th>{{ __('base_price') }}</th>
                                            <th>{{ __('sold_price') }}</th>
                                            <th>{{ __('proof') }}</th>
                                            <th>{{ __('payment') }}</th>
                                            <th>{{ __('player_status') }}</th>
                                            <th>{{ __('payment_status') }}</th>
                                            <th>{{ __('status') }}</th>
                                            <th class="text-center">{{ __('actions') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($players as $key => $player)
                                            <tr>

                                                <td>{{ $key + 1 }}</td>

                                                {{-- Photo --}}
                                                <td>
                                                    @if ($player->photo)
                                                        <img src="{{ asset('storage/' . $player->photo) }}" width="40"
                                                            height="40" class="rounded player-media-thumb"
                                                            style="cursor:pointer"
                                                            data-img="{{ asset('storage/' . $player->photo) }}"
                                                            data-title="{{ $player->name }} - {{ __('photo') }}"
                                                            data-toggle="modal" data-target="#mediaViewerModal">
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>

                                                <td>{{ $player->name }}</td>

                                                <td>{{ $player->player_number ?? '-' }}</td>

                                                <td>{{ $player->team->name ?? '-' }}</td>

                                                <td>{{ $player->tournament->name ?? '-' }}</td>

                                                {{-- Role (int → label) --}}
                                                <td>{{ $player->detail->role_label ?? '-' }}</td>

                                                {{-- Batting Style --}}
                                                <td>
                                                    @php
                                                        $battingStyle = $player->detail->batting_style ?? null;
                                                    @endphp
                                                    @if ($battingStyle === 'right_handed')
                                                        {{ __('right_handed') }}
                                                    @elseif ($battingStyle === 'left_handed')
                                                        {{ __('left_handed') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- Bowling Style --}}
                                                <td>
                                                    @php
                                                        $bowlingStyle = $player->detail->bowling_style ?? null;
                                                    @endphp
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
                                                    @if ($player->detail->sold_price ?? null)
                                                        ₹ {{ number_format((float) $player->detail->sold_price) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- Original Proof --}}
                                                <td>
                                                    @php
                                                        $proof = $player->detail->original_proof ?? null;
                                                    @endphp
                                                    @if ($proof)
                                                        @if (Str::endsWith(strtolower($proof), ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                                            <img src="{{ asset('storage/' . $proof) }}" width="40"
                                                                height="40" class="rounded player-media-thumb"
                                                                style="cursor:pointer"
                                                                data-img="{{ asset('storage/' . $proof) }}"
                                                                data-title="{{ $player->name }} - {{ __('original_proof') }}"
                                                                data-toggle="modal" data-target="#mediaViewerModal">
                                                        @else
                                                            <a href="{{ asset('storage/' . $proof) }}" target="_blank"
                                                                class="btn btn-sm btn-info" title="{{ __('original_proof') }}">
                                                                <i class="fas fa-file"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>

                                                {{-- Payment Screenshot --}}
                                                <td>
                                                    @php
                                                        $paymentScreenshot =
                                                            $player->detail->payment_screenshot ?? null;
                                                    @endphp
                                                    @if ($paymentScreenshot)
                                                        @if (Str::endsWith(strtolower($paymentScreenshot), ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                                            <img src="{{ asset('storage/' . $paymentScreenshot) }}"
                                                                width="40" height="40" class="rounded player-media-thumb"
                                                                style="cursor:pointer"
                                                                data-img="{{ asset('storage/' . $paymentScreenshot) }}"
                                                                data-title="{{ $player->name }} - {{ __('payment_screenshot') }}"
                                                                data-toggle="modal" data-target="#mediaViewerModal">
                                                        @else
                                                            <a href="{{ asset('storage/' . $paymentScreenshot) }}"
                                                                target="_blank" class="btn btn-sm btn-info"
                                                                title="{{ __('payment_screenshot') }}">
                                                                <i class="fas fa-file"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>

                                                {{-- Player Status (sold / unsold) --}}
                                                <td>
                                                    @if (($player->player_status ?? null) === 'sold')
                                                        <span class="badge badge-success">{{ __('sold') }}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ __('unsold') }}</span>
                                                    @endif
                                                </td>

                                                {{-- Payment Status (paid / not_paid) --}}
                                                <td>
                                                    @if (($player->payment_status ?? null) === 'paid')
                                                        <span class="badge badge-success">{{ __('paid') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('not_paid') }}</span>
                                                    @endif
                                                </td>

                                                {{-- Active / Inactive --}}
                                                <td>
                                                    @if ($player->status)
                                                        <span class="badge badge-success">{{ __('active') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('inactive') }}</span>
                                                    @endif
                                                </td>

                                                {{-- Actions --}}
                                                <td class="text-center">

                                                    <a href="{{ route('players.show', $player->id) }}"
                                                        class="btn btn-sm btn-primary" title="{{ __('view') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('players.edit', $player->id) }}"
                                                        class="btn btn-sm btn-primary" title="{{ __('edit') }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('players.destroy', $player->id) }}" method="POST"
                                                        style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            title="{{ __('delete') }}"
                                                            onclick="return confirm('{{ __('are_you_sure') }}')">
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

    {{-- Shared Media Viewer Modal --}}
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

@section('script')
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // DataTable
            new DataTable('#players_list_table', {
                paging: true,
                searching: true,
                ordering: true,
                scrollX: true,
                language: {
                    emptyTable: "{{ __('could_not_find_data') }}"
                }
            });

            // Media preview modal
            $(document).on('click', '[data-toggle="modal"][data-target="#mediaViewerModal"]', function() {
                $('#mediaViewerImage').attr('src', $(this).data('img'));
                $('#mediaViewerModalLabel').text($(this).data('title') || '{{ __('preview') }}');
            });

        });
    </script>
@endsection
