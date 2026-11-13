@extends('layouts.main')

@section('title')
    {{ __('edit') . ' ' . __('player') }}
@endsection

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('edit') . ' ' . __('player') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('home') }}" class="text-dark"><i
                                    class="fas fa-home mr-1"></i>{{ __('dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ url('players') }}" class="text-dark"><i
                                    class="nav-icon fas fa-user-friends mr-1"></i>{{ __('players') }}</a>
                        </li>
                        <li class="breadcrumb-item active brand-red"><i
                                class="nav-icon fas fa-user-edit mr-1"></i>{{ __('edit') . ' ' . __('player') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('edit') . ' ' . __('player') }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('players/' . $player->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    <!-- Tournament -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Tournament </label>
                                            <select name="tournament_id" id="tournament_id"
                                                class="form-control required-field @error('tournament_id') is-invalid @enderror">
                                                <option value="">Select Tournament</option>
                                                @foreach ($tournaments as $tournament)
                                                    <option value="{{ $tournament->id }}"
                                                        data-short-code="{{ $tournament->short_code }}"
                                                        {{ old('tournament_id', $player->tournament_id) == $tournament->id ? 'selected' : '' }}>
                                                        {{ $tournament->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <span class="error-message text-danger"></span>

                                            @error('tournament_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Team -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Team</label>
                                            <select name="team_id"
                                                class="form-control @error('team_id') is-invalid @enderror">
                                                <option value="">Select Team</option>
                                                @foreach ($teams as $team)
                                                    <option value="{{ $team->id }}"
                                                        {{ old('team_id', $player->team_id) == $team->id ? 'selected' : '' }}>
                                                        {{ $team->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('team_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Player Number (readonly) -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Player Number</label>
                                            <input type="text" name="player_number" id="player_number"
                                                value="{{ old('player_number', $player->player_number) }}"
                                                class="form-control @error('player_number') is-invalid @enderror"
                                                placeholder="Auto-generated" readonly>

                                            <small class="text-muted">Changes only when tournament changes</small>

                                            @error('player_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Player Name -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Player Name </label>
                                            <input type="text" name="name" value="{{ old('name', $player->name) }}"
                                                class="form-control required-field @error('name') is-invalid @enderror"
                                                placeholder="Enter player name">

                                            <span class="error-message text-danger"></span>

                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Phone Number</label>
                                            <input type="text" name="phone" value="{{ old('phone', $player->phone) }}"
                                                class="form-control required-field @error('phone') is-invalid @enderror"
                                                placeholder="Enter phone number">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="email" name="email" value="{{ old('email', $player->email) }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Enter email address">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @php
                                        // player_details.role stores int: 1=batsman, 2=bowler, 3=wicket_keeper, 4=all_rounder
                                        $roleInt = (int) ($player->detail->role ?? 0);
                                        $roleMap = [
                                            1 => 'batsman',
                                            2 => 'bowler',
                                            3 => 'wicket_keeper',
                                            4 => 'all_rounder',
                                        ];
                                        $roleVal = old('role', $roleMap[$roleInt] ?? '');
                                    @endphp

                                    <!-- Role -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Role </label>
                                            <select name="role"
                                                class="form-control required-field @error('role') is-invalid @enderror">
                                                <option value="">Select Role</option>
                                                <option value="batsman" {{ $roleVal == 'batsman' ? 'selected' : '' }}>
                                                    Batsman</option>
                                                <option value="bowler" {{ $roleVal == 'bowler' ? 'selected' : '' }}>Bowler
                                                </option>
                                                <option value="wicket_keeper"
                                                    {{ $roleVal == 'wicket_keeper' ? 'selected' : '' }}>Wicket Keeper
                                                </option>
                                                <option value="all_rounder"
                                                    {{ $roleVal == 'all_rounder' ? 'selected' : '' }}>All-Rounder</option>
                                            </select>

                                            <span class="error-message text-danger"></span>

                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Batting Style -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Batting Style </label>
                                            <select name="batting_style"
                                                class="form-control required-field @error('batting_style') is-invalid @enderror">
                                                <option value="">Select Batting Style</option>
                                                <option value="right_handed"
                                                    {{ old('batting_style', $player->detail->batting_style ?? '') == 'right_handed' ? 'selected' : '' }}>
                                                    Right Handed</option>
                                                <option value="left_handed"
                                                    {{ old('batting_style', $player->detail->batting_style ?? '') == 'left_handed' ? 'selected' : '' }}>
                                                    Left Handed</option>
                                            </select>

                                            <span class="error-message text-danger"></span>

                                            @error('batting_style')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Bowling Style -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Bowling Style </label>
                                            <select name="bowling_style"
                                                class="form-control required-field @error('bowling_style') is-invalid @enderror">
                                                <option value="">Select Bowling Style</option>
                                                <option value="na"
                                                    {{ old('bowling_style', $player->detail->bowling_style ?? '') == 'na' ? 'selected' : '' }}>
                                                    N/A</option>
                                                <option value="right"
                                                    {{ old('bowling_style', $player->detail->bowling_style ?? '') == 'right' ? 'selected' : '' }}>
                                                    Right</option>
                                                <option value="left"
                                                    {{ old('bowling_style', $player->detail->bowling_style ?? '') == 'left' ? 'selected' : '' }}>
                                                    Left</option>
                                            </select>

                                            <span class="error-message text-danger"></span>

                                            @error('bowling_style')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- City -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city"
                                                value="{{ old('city', $player->detail->city ?? '') }}"
                                                class="form-control @error('city') is-invalid @enderror"
                                                placeholder="Enter city">

                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Base Price -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Base Price</label>
                                            <input type="number" name="base_price"
                                                value="{{ old('base_price', $player->detail->base_price ?? '') }}"
                                                class="form-control @error('base_price') is-invalid @enderror"
                                                placeholder="Enter base price">

                                            @error('base_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Sold Price / Points (Added to match DB) -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sold Points (Auction)</label>
                                            <input type="number" name="sold_out_points"
                                                value="{{ old('sold_out_points', $player->sold_out_points ?? '') }}"
                                                class="form-control @error('sold_out_points') is-invalid @enderror"
                                                placeholder="Enter sold points">
                                            <small class="text-muted">Actual points paid by the team.</small>
                                            @error('sold_out_points')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Player Status -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Player Status </label>
                                            <select name="player_status"
                                                class="form-control required-field @error('player_status') is-invalid @enderror">
                                                <option value="pending"
                                                    {{ old('player_status', $player->player_status ?? '') == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="unsold"
                                                    {{ old('player_status', $player->player_status ?? '') == 'unsold' ? 'selected' : '' }}>
                                                    Unsold</option>
                                                <option value="sold"
                                                    {{ old('player_status', $player->player_status ?? '') == 'sold' ? 'selected' : '' }}>
                                                    Sold</option>
                                            </select>

                                            <span class="error-message text-danger"></span>

                                            @error('player_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Payment Status -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Payment Status </label>
                                            <select name="payment_status"
                                                class="form-control required-field @error('payment_status') is-invalid @enderror">
                                                <option value="not_paid"
                                                    {{ old('payment_status', $player->payment_status ?? '') == 'not_paid' ? 'selected' : '' }}>
                                                    Not Paid</option>
                                                <option value="paid"
                                                    {{ old('payment_status', $player->payment_status ?? '') == 'paid' ? 'selected' : '' }}>
                                                    Paid</option>
                                            </select>

                                            <span class="error-message text-danger"></span>

                                            @error('payment_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Registration Status -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Registration Status</label>
                                            <select name="registration_status"
                                                class="form-control required-field @error('registration_status') is-invalid @enderror">
                                                <option value="pending"
                                                    {{ old('registration_status', $player->registration_status ?? '') == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="approved"
                                                    {{ old('registration_status', $player->registration_status ?? '') == 'approved' ? 'selected' : '' }}>
                                                    Approved</option>
                                                <option value="rejected"
                                                    {{ old('registration_status', $player->registration_status ?? '') == 'rejected' ? 'selected' : '' }}>
                                                    Rejected</option>
                                            </select>
                                            <span class="error-message text-danger"></span>
                                            @error('registration_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Payment Reference -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Payment Reference / UTR</label>
                                            <input type="text" name="payment_reference"
                                                value="{{ old('payment_reference', $player->detail->payment_reference ?? '') }}"
                                                class="form-control @error('payment_reference') is-invalid @enderror"
                                                placeholder="Enter UTR or transaction ID">
                                            @error('payment_reference')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3" placeholder="Player description">{{ old('description', $player->description ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Player Photo -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Player Photo</label>
                                            <input name="photo" type="file" accept="image/*" class="filepond">
                                            @if ($player->photo)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $player->photo) }}" width="80"
                                                        class="rounded border shadow-sm">
                                                    <small class="text-muted d-block mt-1">Current photo — leave empty to
                                                        keep</small>
                                                </div>
                                            @endif
                                            @error('photo')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Payment Screenshot -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Payment Screenshot</label>
                                            <input name="payment_screenshot" type="file" class="filepond">
                                            @if (!empty($player->detail->payment_screenshot))
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $player->detail->payment_screenshot) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/' . $player->detail->payment_screenshot) }}"
                                                            width="80" class="rounded border shadow-sm"
                                                            alt="Payment Screenshot">
                                                    </a>
                                                    <small class="text-muted d-block mt-1">Current screenshot — leave empty
                                                        to keep</small>
                                                </div>
                                            @endif
                                            @error('payment_screenshot')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Original Proof -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Original Proof</label>
                                            <input name="original_proof" type="file" class="filepond">
                                            @if (!empty($player->detail->original_proof))
                                                <div class="mt-2">
                                                    @if (Str::endsWith(strtolower($player->detail->original_proof), ['.jpg', '.jpeg', '.png', '.webp']))
                                                        <a href="{{ asset('storage/' . $player->detail->original_proof) }}"
                                                            target="_blank">
                                                            <img src="{{ asset('storage/' . $player->detail->original_proof) }}"
                                                                width="80" class="rounded border shadow-sm"
                                                                alt="Original Proof">
                                                        </a>
                                                    @else
                                                        <a href="{{ asset('storage/' . $player->detail->original_proof) }}"
                                                            target="_blank" class="btn btn-sm btn-info">
                                                            <i class="fas fa-file"></i> View Document
                                                        </a>
                                                    @endif
                                                    <small class="text-muted d-block mt-1">Current proof — leave empty to
                                                        keep</small>
                                                </div>
                                            @endif
                                            @error('original_proof')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <div class="form-check form-switch d-flex align-items-center">
                                                <label class="mr-2 font-weight-bold">Active / Inactive</label>
                                                <input class="form-check-input status-switch" type="checkbox"
                                                    name="status" id="status" {{ $player->status ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="col-md-12 text-right border-top pt-3">
                                        <a href="{{ url('players') }}" class="btn btn-default" style="padding:7px">
                                            <i class="fas fa-arrow-left"></i> {{ __('back') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> {{ __('update') }}
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        var switcheryInstances = [];
        document.addEventListener('DOMContentLoaded', function() {

            var elems = Array.prototype.slice.call(document.querySelectorAll(".status-switch"));
            elems.forEach(function(elem) {
                var switchery = new Switchery(elem, {
                    size: "small",
                    color: "#47C363",
                    secondaryColor: "#EB4141",
                    jackColor: "#ffff",
                    jackSecondaryColor: "#ffff",
                });
                switcheryInstances.push(switchery);
            });

            const tournamentSelect = document.getElementById('tournament_id');
            const playerNumberInput = document.getElementById('player_number');
            const playerId = '{{ $player->id ?? '' }}';
            const originalNumber = '{{ old('player_number', $player->player_number) }}';
            const initialTournament = tournamentSelect ? tournamentSelect.value : '';

            if (tournamentSelect) {
                tournamentSelect.addEventListener('change', function() {
                    const tournamentId = this.value;

                    if (tournamentId === initialTournament) {
                        playerNumberInput.value = originalNumber;
                        return;
                    }

                    if (!tournamentId) {
                        playerNumberInput.value = '';
                        return;
                    }

                    playerNumberInput.value = 'Loading...';

                    const params = new URLSearchParams({
                        tournament_id: tournamentId,
                        player_id: playerId,
                    });

                    fetch(`{{ route('players.generate-number') }}?${params.toString()}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            playerNumberInput.value = data.player_number || '';
                        })
                        .catch(() => {
                            playerNumberInput.value = '';
                        });
                });
            }
        });
    </script>
@endsection
