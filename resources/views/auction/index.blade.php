@extends('layouts.main')

@section('title')
    {{ __('auction_details') }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('tournament_details') }}</h1>
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
                        <li class="breadcrumb-item active brand-red"><i
                                class="nav-icon fas fa-newspaper mr-1"></i>{{ __('auction') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-sm border-0">
                        <span class="info-box-icon icon-black elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span
                                class="info-box-text text-muted text-uppercase text-xs font-weight-bold">{{ __('total_players') }}</span>
                            <span
                                class="info-box-number text-xl font-weight-bold text-dark counter">{{ $totalPlayers }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-sm border-0">
                        <span class="info-box-icon icon-green elevation-1"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span
                                class="info-box-text text-muted text-uppercase text-xs font-weight-bold">{{ __('sold') }}</span>
                            <span
                                class="info-box-number text-xl font-weight-bold text-green counter">{{ $soldCount }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-sm border-0">
                        <span class="info-box-icon icon-red elevation-1"><i class="fas fa-times-circle"></i></span>
                        <div class="info-box-content">
                            <span
                                class="info-box-text text-muted text-uppercase text-xs font-weight-bold">{{ __('unsold') }}</span>
                            <span
                                class="info-box-number text-xl font-weight-bold brand-red counter">{{ $unsoldCount }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-sm border-0">
                        <span class="info-box-icon icon-slate elevation-1"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span
                                class="info-box-text text-muted text-uppercase text-xs font-weight-bold">{{ __('remaining') }}</span>
                            <span
                                class="info-box-number text-xl font-weight-bold text-slate counter">{{ $remaining }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 mt-3">
                <div class="col-12 d-flex flex-wrap align-items-center" style="gap: 12px;">

                    <!-- All Players (Link) -->
                    <a href="{{ route('auction.all-players', $tournament->id) }}"
                        class="btn btn-filter-pill btn-filter-default">
                        <i class="fas fa-users mr-2"></i> All Players
                    </a>

                    <!-- All Players — Spin (Active State) -->
                    <a href="{{ route('auction.spin', $tournament->id) }}" class="btn btn-filter-pill btn-filter-active">
                        <i class="fas fa-sync-alt mr-2"></i> All Players — Spin
                    </a>

                    <!-- Unsold Players — Spin -->
                    <a href="{{ route('auction.spin-unsold', $tournament->id) }}"
                        class="btn btn-filter-pill btn-filter-red">
                        <i class="fas fa-history mr-2"></i> Unsold Players — Spin
                    </a>

                    <!-- Teams — Spin -->
                    <a href="{{ route('auction.spin-teams', $tournament->id) }}"
                        class="btn btn-filter-pill btn-filter-default">
                        <i class="fas fa-shield-alt mr-2"></i> Teams — Spin
                    </a>

                    <!-- NEW: Create Teams Button -->
                    <button type="button" class="btn btn-filter-pill btn-filter-active" data-toggle="modal"
                        data-target="#createTeamsModal">
                        <i class="fas fa-plus-circle mr-2"></i> Create Teams
                    </button>

                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12 col-sm-12">
                    <div class="card h-100 shadow-sm border-0">
                        <div
                            class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                            <h3 class="card-title mb-0 font-weight-bold text-dark">{{ __('teams_list') }}</h3>
                            <span class="badge badge-brand px-3 py-2 font-weight-normal ml-auto"
                                style="border-radius: 20px; font-size: 0.95rem;">
                                <i class="fas fa-shield-alt mr-1"></i> {{ count($tournament->teams) }}
                                {{ __('Teams Enrolled') }}
                            </span>
                        </div>

                        @if (count($tournament->teams) == 0)
                            <div class="px-4">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <div class="empty-state" data-height="400" style="height: 400px;">
                                            <div class="empty-state-icon" style="background: #be212a;">
                                                <i class="fas fa-users-slash text-white"></i>
                                            </div>
                                            <h2>{{ __('could_not_find_data') }}</h2>
                                            <p class="lead">No teams found for this tournament.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card-body mt-2">
                                <div class="row">
                                    @foreach ($tournament->teams as $key => $team)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                                            <div class="team-tile h-100">
                                                <div class="team-card-header">
                                                    <div class="d-flex align-items-center">
                                                        <div class="team-avatar mr-3">
                                                            {{ strtoupper(substr($team->name, 0, 2)) }}
                                                        </div>
                                                        <div class="min-w-0">
                                                            <h6 class="font-weight-bold text-dark mb-0 text-truncate"
                                                                title="{{ $team->name }}">
                                                                {{ $team->name }}
                                                            </h6>
                                                            <span
                                                                class="badge badge-light border text-muted">#{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                @php
                                                    $remainingSlots = max(0, $playersPerTeam - $team->player_count);
                                                    $otherSlots = max(0, $remainingSlots - 1);
                                                    $reservedPoints = $otherSlots * $basePoint;
                                                    $maxBid = max(0, $team->available_points - $reservedPoints);

                                                    if ($remainingSlots <= 0) {
                                                        $maxBid = 0;
                                                    }
                                                @endphp

                                                <div class="team-row">
                                                    <span><i class="fas fa-wallet mr-1 text-muted"></i>
                                                        {{ __('available_points') }}</span>
                                                    <strong
                                                        class="text-dark">{{ number_format($team->available_points) }}</strong>
                                                </div>

                                                <div class="team-row">
                                                    <span><i class="fas fa-user-check mr-1 text-muted"></i>
                                                        {{ __('player_count') }}</span>
                                                    <strong class="text-dark">{{ $team->player_count }} <span
                                                            class="text-muted text-xs">/
                                                            {{ $playersPerTeam }}</span></strong>
                                                </div>

                                                <div class="team-row"
                                                    style="background: #f8fafc; margin: 0 -20px; padding: 12px 20px; border-bottom: 1px solid #e5e7eb;">
                                                    <span class="font-weight-bold"
                                                        style="color: var(--brand-secondary); font-size: 14px;">
                                                        <i class="fas fa-gavel mr-1"></i> Max Bid Allowed
                                                    </span>
                                                    <span class="point-badge"
                                                        style="background: #fff; border: 1px solid var(--brand-secondary); color: var(--brand-secondary); border-radius: 20px; padding: 6px 14px; font-weight: 800;">
                                                        {{ number_format($maxBid) }}
                                                    </span>
                                                </div>

                                                <a href="javascript:void(0)"
                                                    class="btn btn-view-players btn-block mt-3 btn-view-team"
                                                    data-toggle="modal" data-target="#playerDetailsModal"
                                                    data-index="{{ $key }}"
                                                    data-team='@json($team)'
                                                    data-maxbid="{{ $maxBid }}"
                                                    data-playersperteam="{{ $playersPerTeam }}">
                                                    <i class="fas fa-users-cog mr-1"></i> {{ __('view_players') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer bg-white text-center py-3">
                                <a href="{{ url('tournaments') }}"
                                    class="btn btn-default border px-4 font-weight-bold btn-back">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('back') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="modal fade" id="playerDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="playerDetailsModalLabel">{{ __('preview') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left" style="background-color: #f4f6f9;">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="team-avatar mr-3" id="modalTeamAvatar"
                                style="width: 54px; height: 54px; font-size: 20px;">
                                TE
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-dark mb-0" id="modalTeamName">Team Name</h4>
                                <span class="text-muted text-sm" id="modalTeamId">#00</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 col-12">
                            <div class="info-box shadow-sm border-0 mb-2">
                                <span class="info-box-icon bg-blue-new">
                                    <i class="fas fa-wallet text-blue-new"></i>
                                </span>
                                <div class="info-box-content">
                                    <span
                                        class="info-box-text text-muted text-uppercase text-xs font-weight-bold">Available
                                        Points</span>
                                    <span class="info-box-number text-dark font-weight-bold"
                                        id="modalAvailablePoints">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="info-box shadow-sm border-0 mb-2">
                                <span class="info-box-icon bg-green-new">
                                    <i class="fas fa-user-check text-green-new"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted text-uppercase text-xs font-weight-bold">Player
                                        Count</span>
                                    <span class="info-box-number text-dark font-weight-bold" id="modalPlayerCount">0 /
                                        15</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="info-box shadow-sm border-0 mb-2">
                                <span class="info-box-icon bg-orange-new">
                                    <i class="fas fa-gavel text-orange-new"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-muted text-uppercase text-xs font-weight-bold">Max Bid
                                        Allowed</span>
                                    <span class="info-box-number brand-red font-weight-bold" id="modalMaxBid">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-list mr-1"></i> Picked Players
                            </h6>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table table-hover mb-0 text-center">
                                <thead class="bg-light text-muted text-uppercase text-xs">
                                    <tr>
                                        <th class="py-3 text-left pl-4">Player</th>
                                        <th class="py-3">Role</th>
                                        <th class="py-3">Base Point</th>
                                        <th class="py-3">Sold Point</th>
                                        <th class="py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="modalPlayersTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="modalNoPlayers" class="text-center text-muted py-5"
                        style="display: none; background: #fff; border-radius: 8px;">
                        <i class="fas fa-users-slash fa-3x mb-3" style="opacity: 0.3;"></i>
                        <h5>No players picked by this team yet.</h5>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createTeamsModal" tabindex="-1" role="dialog" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="createTeamsModalLabel">
                        <i class="fas fa-users mr-2"></i> Create Teams
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="this.blur()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body text-left" style="background-color: #f4f6f9;">

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="info-box-icon bg-blue-new mr-3" style="border-radius: 50%;">
                                <i class="fas fa-trophy text-blue-new"></i>
                            </div>
                            <div>
                                <span class="text-muted text-uppercase text-xs font-weight-bold d-block">Tournament</span>
                                <h5 class="font-weight-bold text-dark mb-0">{{ $tournament->name }}
                                    ({{ $tournament->short_code }})</h5>
                            </div>
                        </div>
                    </div>

                    <form id="bulkTeamForm">
                        <div id="teamRowsWrapper">
                        </div>
                    </form>

                    <div class="text-center mt-3 mb-4">
                        <button type="button" class="btn btn-outline-dark font-weight-bold" id="addTeamRowBtn"
                            style="border-radius: 8px;">
                            <i class="fas fa-plus mr-1"></i> Add Another Team
                        </button>
                    </div>

                </div>

                <div class="modal-footer border-top-0" style="background-color: #f4f6f9;">
                    <button type="button" class="btn btn-light border font-weight-bold px-4"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary font-weight-bold px-5" id="saveTeamsBtn">
                        <i class="fas fa-save mr-2"></i> Save Teams
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <style>
        .text-green {
            color: #16a34a !important;
        }

        .text-slate {
            color: #475569 !important;
        }

        .badge-brand {
            background: var(--brand-primary);
            color: #fff;
        }

        .info-box .info-box-icon {
            color: #fff;
        }

        .icon-black {
            background: var(--brand-primary);
        }

        .icon-green {
            background: #16a34a;
        }

        .icon-red {
            background: var(--brand-secondary);
        }

        .icon-slate {
            background: #475569;
        }

        .team-tile {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .team-tile::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--brand-primary), var(--brand-secondary));
        }

        .team-tile:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.2);
        }

        .team-avatar {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #f3f4f6;
            color: var(--brand-primary);
            border: 2px solid var(--brand-secondary-line);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 16px;
        }

        .team-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-top: 1px dashed #e5e7eb;
            font-size: .875rem;
            font-weight: 600;
            color: #6b7280;
        }

        .point-badge {
            background: var(--brand-secondary-soft);
            color: var(--brand-secondary);
            font-weight: 800;
            font-size: 13px;
            padding: 4px 10px;
            border-radius: 20px;
            border: 1px solid var(--brand-secondary-line);
        }

        .btn-view-players {
            background: var(--brand-primary);
            color: #ffffff;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            transition: background .2s ease;
        }

        .btn-view-players:hover {
            background: var(--brand-secondary);
            color: #ffffff;
        }

        .btn-back:hover {
            border-color: var(--brand-secondary) !important;
            color: var(--brand-secondary);
        }

        .min-w-0 {
            min-width: 0;
        }

        .btn-filter-pill {
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid transparent;
        }

        .btn-filter-default {
            background-color: transparent;
            border-color: #cbd5e1;
            color: #475569;
        }

        .btn-filter-default:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
            color: #1e293b;
            transform: translateY(-1px);
        }

        .btn-filter-red {
            background-color: transparent;
            border-color: var(--brand-secondary);
            color: var(--brand-secondary);
        }

        .btn-filter-red:hover {
            background-color: var(--brand-secondary-soft);
            border-color: var(--brand-secondary-dark);
            color: var(--brand-secondary-dark);
            transform: translateY(-1px);
        }

        .btn-filter-active {
            background-color: var(--brand-secondary);
            border-color: var(--brand-secondary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(190, 33, 42, 0.25);
        }

        .btn-filter-active:hover {
            background-color: var(--brand-secondary-dark);
            border-color: var(--brand-secondary-dark);
            color: #ffffff;
            transform: translateY(-1px);
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">
        $(".counter").each(function() {
            $(this).prop("Counter", 0).animate({
                Counter: $(this).text(),
            }, {
                duration: 1600,
                easing: "swing",
                step: function(now) {
                    $(this).text(Math.ceil(now));
                },
            });
        });

        $(document).on('click', '.btn-view-team', function() {
            let team = $(this).data('team');
            let maxBid = $(this).data('maxbid');
            let playersPerTeam = $(this).data('playersperteam');
            let index = $(this).data('index');

            let formattedIndex = '#' + String(index + 1).padStart(2, '0');

            $('#mediaViewerModalLabel').html(`<i class="fas fa-users mr-2"></i> Team Details`);
            $('#modalTeamName').text(team.name);
            $('#modalTeamAvatar').text(team.name.substring(0, 2).toUpperCase());
            $('#modalTeamId').text(formattedIndex);

            $('#modalAvailablePoints').text(Number(team.available_points).toLocaleString());
            $('#modalPlayerCount').text(team.player_count + ' / ' + playersPerTeam);
            $('#modalMaxBid').text(Number(maxBid).toLocaleString());

            let tbody = $('#modalPlayersTableBody');
            tbody.empty();

            if (team.players && team.players.length > 0) {
                $('#modalNoPlayers').hide();
                $('.table-responsive').show();

                team.players.forEach(function(player) {
                    let roleNames = {
                        1: 'Batsman',
                        2: 'Bowler',
                        3: 'Wicket Keeper',
                        4: 'All-Rounder'
                    };
                    let roleName = roleNames[player.detail?.role] || 'N/A';

                    let statusBadge = player.player_status === 'sold' ?
                        '<span class="badge badge-success">Sold</span>' :
                        '<span class="badge badge-warning">Unsold</span>';

                    let playerInitial = player.name.substring(0, 2).toUpperCase();

                    let row = `
                        <tr>
                            <td class="align-middle text-left pl-4">
                                <div class="d-flex align-items-center">
                                    <div class="team-avatar mr-2" style="width: 32px; height: 32px; font-size: 12px;">
                                        ${playerInitial}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark">${player.name}</div>
                                        <div class="text-xs text-muted">${player.player_number ?? '-'}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle font-weight-bold text-muted">${roleName}</td>
                            <td class="align-middle">${Number(player.detail?.base_price || 0).toLocaleString()}</td>
                            <td class="align-middle font-weight-bold" style="color: #dd6b20;">
                                ${Number(player.sold_out_points || 0).toLocaleString()}
                            </td>
                            <td class="align-middle">${statusBadge}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            } else {
                $('.table-responsive').hide();
                $('#modalNoPlayers').show();
            }
        });


        $(document).ready(function() {
            let rowIndex = 0;

            function getTeamRowHtml(index) {
                return `
                    <div class="card shadow-sm border-0 mb-3 team-row-card" data-index="${index}">
                        <div class="card-body p-3 position-relative">
                            
                            <!-- Remove Button -->
                            <button type="button" class="btn btn-sm btn-danger remove-row-btn position-absolute" style="top: 10px; right: 10px; border-radius: 50%; width: 28px; height: 28px; padding: 0; z-index: 10;">
                                <i class="fas fa-times" style="font-size: 12px;"></i>
                            </button>
                            
                            <div class="row mt-2">
                                <div class="col-md-6 mb-2">
                                    <label class="font-weight-bold text-muted text-xs mb-1">Team Name <span class="text-danger">*</span></label>
                                    <input type="text" name="teams[${index}][name]" class="form-control team-name-input" placeholder="e.g. YOUNG BLOOD CRICKET CLUB" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="font-weight-bold text-muted text-xs mb-1">Short Name</label>
                                    <input type="text" name="teams[${index}][short_name]" class="form-control" placeholder="e.g. YBCC">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="font-weight-bold text-muted text-xs mb-1">Owner Name</label>
                                    <input type="text" name="teams[${index}][owner_name]" class="form-control" placeholder="Owner Name">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="font-weight-bold text-muted text-xs mb-1">Contact Email</label>
                                    <input type="email" name="teams[${index}][contact_email]" class="form-control" placeholder="Email">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="font-weight-bold text-muted text-xs mb-1">Contact Phone</label>
                                    <input type="text" name="teams[${index}][contact_phone]" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            $('#addTeamRowBtn').on('click', function() {
                $('#teamRowsWrapper').append(getTeamRowHtml(rowIndex));
                rowIndex++;
                $('#teamRowsWrapper').scrollTop($('#teamRowsWrapper')[0].scrollHeight);
            });

            $(document).on('click', '.remove-row-btn', function(e) {
                e.preventDefault();
                if ($('.team-row-card').length > 1) {
                    $(this).closest('.team-row-card').remove();
                } else {
                    $(this).closest('.team-row-card').find('input').val('');
                    showErrorToast('Cannot remove the last row. Fields cleared instead.');
                }
            });

            $('#createTeamsModal').on('show.bs.modal', function() {
                $('#teamRowsWrapper').empty();
                rowIndex = 0;
                $('#addTeamRowBtn').trigger('click');
            });

            $('#saveTeamsBtn').on('click', function() {
                let formData = $('#bulkTeamForm').serialize();
                let btn = $(this);

                let isValid = true;
                $('#bulkTeamForm').find('input[required]').each(function() {
                    if ($(this).val().trim() === '') {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    showErrorToast('Please fill in all required fields (Team Name).');
                    return;
                }

                btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Saving...');
                btn.prop('disabled', true);

                $.ajax({
                    url: "{{ route('auction.bulk-create-teams', $tournament->id) }}",
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            showSuccessToast(res.message);
                            $('#createTeamsModal').modal('hide');
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            showErrorToast(res.message);
                            btn.html('<i class="fas fa-save mr-2"></i> Save Teams');
                            btn.prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Something went wrong.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        showErrorToast(msg);
                        btn.html('<i class="fas fa-save mr-2"></i> Save Teams');
                        btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
