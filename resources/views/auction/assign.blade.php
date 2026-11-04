@extends('layouts.main')

@section('title')
    Assign Player - {{ $tournament->name }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">Auction Assignment</h1>
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
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('auction.spin', $tournament->id) }}" class="text-dark"><i
                                    class="nav-icon fas fa-sync-alt mr-1"></i>Spin</a>
                        </li>
                        <li class="breadcrumb-item active brand-red"><i class="nav-icon fas fa-user-plus mr-1"></i>Assign
                            Player</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <form action="{{ route('auction.assign-player', $tournament->id) }}" method="POST">
                @csrf
                <input type="hidden" name="player_id" value="{{ $player->id }}">
                <input type="hidden" name="spin_type" value="{{ $spinType ?? 'pending' }}">

                <div class="row">
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card shadow-sm border-0"
                            style="border-radius: 16px; overflow: hidden; background: #fff;">

                            <div class="text-center pt-4 pb-4" style="background-color: #000000; color: #fff;">

                                <div class="position-relative mb-3 px-3">
                                    @php
                                        $photoPath = $player->photo ? public_path('storage/' . $player->photo) : null;
                                        $hasPhoto = $photoPath && file_exists($photoPath);
                                    @endphp

                                    @if ($hasPhoto)
                                        <img src="{{ asset('storage/' . $player->photo) }}"
                                            class="img-fluid rounded shadow-lg"
                                            style="width: 100%; height: 280px; object-fit: cover; object-position: top;">
                                    @else
                                        <div class="rounded shadow-lg d-flex align-items-center justify-content-center mx-auto"
                                            style="width: 100%; height: 280px; background: #1a1a1a; font-size: 60px; font-weight: bold; color: #fff;">
                                            {{ strtoupper(substr($player->name, 0, 2)) }}
                                        </div>
                                    @endif

                                    @if ($hasPhoto)
                                        <button type="button" class="btn btn-light btn-sm font-weight-bold shadow-sm mt-3"
                                            style="border-radius: 20px;" data-toggle="modal" data-target="#fullImageModal">
                                            <i class="fas fa-search-plus mr-1"></i> View Full Image
                                        </button>
                                    @endif
                                </div>

                                <h3 class="font-weight-bold mb-1">{{ $player->name }}</h3>

                                <p class="text-muted mb-3 font-weight-bold" style="letter-spacing: 1px;">
                                    #{{ $player->player_number ?? 'N/A' }}
                                </p>

                                @php
                                    $roles = [1 => 'Batsman', 2 => 'Bowler', 3 => 'Wicket Keeper', 4 => 'All-Rounder'];
                                    $roleName = $roles[$player->detail->role ?? 0] ?? 'Player';
                                @endphp
                                <span class="badge badge-warning text-dark font-weight-bold px-3 py-2"
                                    style="border-radius: 20px; font-size: 14px;">
                                    <i class="fas fa-star mr-1"></i> {{ strtoupper($roleName) }}
                                </span>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-8 col-md-12">

                        <div class="card card-secondary mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Technical Attributes</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-purple-new">
                                                <i class="fas fa-bolt text-purple-new"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Batting Style</span>
                                                <span class="info-box-number">
                                                    @if (($player->detail->batting_style ?? null) === 'right_handed')
                                                        Right Handed
                                                    @elseif(($player->detail->batting_style ?? null) === 'left_handed')
                                                        Left Handed
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-sky-new">
                                                <i class="fas fa-bullseye text-sky-new"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Bowling Style</span>
                                                <span class="info-box-number">
                                                    @if (($player->detail->bowling_style ?? null) === 'right')
                                                        Right Arm
                                                    @elseif(($player->detail->bowling_style ?? null) === 'left')
                                                        Left Arm
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Auction / Team Assignment</h3>
                            </div>
                            <div class="card-body">

                                @if ($player->team_id && $player->player_status === 'sold')
                                    <div class="row mt-2">
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-blue-new">
                                                    <i class="fas fa-shield-alt text-blue-new"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Picked By Team</span>
                                                    <span class="info-box-number">
                                                        {{ $player->team->name ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-orange-new">
                                                    <i class="fas fa-coins text-orange-new"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Sold Price / Points</span>
                                                    <span class="info-box-number">
                                                        {{ number_format($player->sold_out_points) }} PTS
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right mt-3">
                                        <a href="{{ isset($spinType) && $spinType === 'unsold' ? route('auction.spin-unsold', $tournament->id) : route('auction.spin', $tournament->id) }}"
                                            class="btn btn-default ...">
                                            <i class="fas fa-arrow-left"></i> Back to Spin
                                        </a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#revertModal">
                                            <i class="fas fa-undo"></i> Revert / Re-assign
                                        </button>
                                    </div>
                                @else
                                    <div class="row mt-2">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold text-muted text-sm">Select Franchise / Team
                                                <span class="text-danger">*</span></label>
                                            <select name="team_id" id="teamSelect" class="form-control form-control-lg"
                                                required style="border-radius: 8px;">
                                                <option value="">-- Choose Team --</option>
                                                @foreach ($teams as $team)
                                                    <option value="{{ $team->id }}">
                                                        {{ $team->name }} (Pts:
                                                        {{ number_format($team->available_points) }}
                                                        | Pld:
                                                        {{ $team->player_count }}/{{ $tournament->players_per_team }}
                                                        | Max Bid: {{ number_format($team->max_bid) }})
                                                    </option>
                                                @endforeach
                                                <option value="unsold" class="text-danger font-weight-bold">-- Mark as
                                                    UNSOLD --</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold text-muted text-sm">Sold Price / Points <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0"><i
                                                            class="fas fa-coins text-muted"></i></span>
                                                </div>
                                                <input type="number" name="points" id="pointsInput"
                                                    class="form-control border-left-0" placeholder="e.g. 5000"
                                                    min="0" style="border-radius: 0 8px 8px 0;">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-light font-weight-bold">PTS</span>
                                                </div>
                                            </div>
                                            <small class="text-muted mt-2 d-block" id="pointHelpText"></small>
                                        </div>
                                    </div>

                                    <div class="text-right mt-3">
                                        <a href="{{ route('auction.spin', $tournament->id) }}"
                                            class="btn btn-default mr-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check-circle mr-1"></i> Confirm Assignment
                                        </button>
                                    </div>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </form>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <h4 class="font-weight-bold text-dark mb-0"><i class="fas fa-shield-alt mr-2"></i> Teams Overview
                        </h4>
                        <span class="badge badge-brand px-3 py-2 font-weight-normal" style="border-radius: 20px;">
                            <i class="fas fa-shield-alt mr-1"></i> {{ count($teams) }} {{ __('Teams Enrolled') }}
                        </span>
                    </div>

                    <div class="d-flex flex-nowrap overflow-auto pb-4" style="gap: 20px; scrollbar-width: thin;">
                        @foreach ($teams as $key => $team)
                            <div class="team-card-wrapper" style="min-width: 320px; max-width: 320px;">
                                <div class="team-tile h-100 shadow-sm">
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
                                        $remainingSlots = max(0, $tournament->players_per_team - $team->player_count);
                                        $otherSlots = max(0, $remainingSlots - 1);
                                        $reservedPoints = $otherSlots * $tournament->base_point;
                                        $maxBid = max(0, $team->available_points - $reservedPoints);

                                        if ($remainingSlots <= 0) {
                                            $maxBid = 0;
                                        }
                                    @endphp

                                    <div class="team-row">
                                        <span><i class="fas fa-wallet mr-1 text-muted"></i>
                                            {{ __('available_points') }}</span>
                                        <strong class="text-dark">{{ number_format($team->available_points) }}</strong>
                                    </div>

                                    <div class="team-row">
                                        <span><i class="fas fa-user-check mr-1 text-muted"></i>
                                            {{ __('player_count') }}</span>
                                        <strong class="text-dark">{{ $team->player_count }} <span
                                                class="text-muted text-xs">/
                                                {{ $tournament->players_per_team }}</span></strong>
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

                                    <button type="button" class="btn btn-view-players btn-block mt-3 btn-view-team"
                                        data-toggle="modal" data-target="#playerDetailsModal"
                                        data-index="{{ $key }}" data-team="{{ json_encode($team) }}"
                                        data-maxbid="{{ $maxBid }}"
                                        data-playersperteam="{{ $tournament->players_per_team }}">
                                        <i class="fas fa-users-cog mr-1"></i> {{ __('view_players') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="modal fade" id="playerDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="mediaViewerModalLabel">{{ __('preview') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="this.blur()">
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

    <div class="modal fade" id="fullImageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg" style="background: transparent;">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                        onclick="this.blur()" style="opacity: 1; text-shadow: 0 2px 4px rgba(0,0,0,0.8);">
                        <span aria-hidden="true" style="font-size: 2rem;">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center p-0">
                    <img src="{{ asset('storage/' . $player->photo) }}" class="img-fluid rounded shadow-lg"
                        alt="{{ $player->name }}" style="max-height: 85vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="revertModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Revert
                        Player</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" onclick="this.blur()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('auction.revert-player', $tournament->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="player_id" value="{{ $player->id }}">

                    <div class="modal-body p-4">
                        <p class="text-muted mb-4">Are you sure you want to revert this player? Choose an action below:</p>

                        <div class="custom-control custom-radio mb-3">
                            <input class="custom-control-input" type="radio" id="actionRevert" name="action"
                                value="revert" checked onchange="toggleReassignFields()">
                            <label class="custom-control-label font-weight-bold text-dark" for="actionRevert">
                                Revert to Auction Pool (Mark as Pending)
                            </label>
                        </div>

                        <div class="custom-control custom-radio mb-4">
                            <input class="custom-control-input" type="radio" id="actionReassign" name="action"
                                value="reassign" onchange="toggleReassignFields()">
                            <label class="custom-control-label font-weight-bold text-dark" for="actionReassign">
                                Assign to Another Team
                            </label>
                        </div>

                        <div id="reassignFields"
                            style="display: none; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark text-sm">Select New Team <span
                                        class="text-danger">*</span></label>
                                <select name="new_team_id" class="form-control" style="border-radius: 6px;">
                                    <option value="">-- Choose Team --</option>
                                    @foreach ($teams as $team)
                                        @if ($player->team_id == $team->id)
                                            @continue
                                        @endif

                                        <option value="{{ $team->id }}">
                                            {{ $team->name }}
                                            (Pts: {{ number_format($team->available_points) }} |
                                            Pld: {{ $team->player_count }}/{{ $tournament->players_per_team }} |
                                            Max Bid: {{ number_format($team->max_bid) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-dark text-sm">New Sold Price / Points <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="new_points" class="form-control" placeholder="e.g. 5000"
                                    min="0" style="border-radius: 6px;">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-default border" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger font-weight-bold">Confirm Action</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        :root {
            --brand-primary: #000000;
            --brand-secondary: #be212a;
            --brand-secondary-dark: #9a1a22;
            --brand-secondary-soft: #fdf2f3;
            --brand-secondary-line: #f3c9cc;
        }

        .brand-red {
            color: var(--brand-secondary) !important;
        }

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

        .min-w-0 {
            min-width: 0;
        }

        .overflow-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection

@section('script')
    <script>
        document.getElementById('teamSelect')?.addEventListener('change', function() {
            const teamText = this.options[this.selectedIndex].text;
            const pointsInput = document.getElementById('pointsInput');
            const pointHelp = document.getElementById('pointHelpText');

            if (this.value === 'unsold') {
                pointsInput.value = '';
                pointsInput.disabled = true;
                pointHelp.innerHTML =
                    '<span class="text-danger font-weight-bold">Player will be marked as UNSOLD.</span>';
            } else {
                pointsInput.disabled = false;

                const ptsMatch = teamText.match(/Pts:\s*([\d,]+)/);
                const maxMatch = teamText.match(/Max Bid:\s*([\d,]+)/);

                if (ptsMatch && maxMatch) {
                    pointHelp.innerHTML =
                        `Available Points: <strong>${ptsMatch[1]}</strong> | Max Bid Allowed: <strong style="color: #be212a;">${maxMatch[1]}</strong>`;
                } else if (ptsMatch) {
                    pointHelp.innerHTML = `Team Available Points: <strong>${ptsMatch[1]}</strong>`;
                } else {
                    pointHelp.innerHTML = '';
                }
            }
        });

        $(document).on('click', '.btn-view-team', function() {
            let team = $(this).data('team');
            let maxBid = $(this).data('maxbid');
            let playersPerTeam = $(this).data('playersperteam');
            let index = $(this).data('index');

            if (typeof team === 'string') {
                try {
                    team = JSON.parse(team);
                } catch (e) {
                    team = {};
                }
            }

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

            if (team.players && Array.isArray(team.players) && team.players.length > 0) {
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

        function toggleReassignFields() {
            const isReassign = document.getElementById('actionReassign').checked;
            const fields = document.getElementById('reassignFields');
            const selects = fields.querySelectorAll('select, input');

            if (isReassign) {
                fields.style.display = 'block';
                selects.forEach(el => el.setAttribute('required', 'required'));
            } else {
                fields.style.display = 'none';
                selects.forEach(el => el.removeAttribute('required'));
            }
        }

        document.querySelector('select[name="new_team_id"]')?.addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            const pointsInput = document.querySelector('input[name="new_points"]');

            if (this.value) {
                const match = selectedText.match(/Max Bid:\s*([\d,]+)/);
                if (match) {
                    pointsInput.placeholder = `Max allowed: ${match[1]}`;
                    pointsInput.max = match[1].replace(/,/g, '');
                }
            } else {
                pointsInput.placeholder = "e.g. 5000";
                pointsInput.removeAttribute('max');
            }
        });
    </script>
@endsection
