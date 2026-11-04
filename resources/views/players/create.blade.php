@extends('layouts.main')

@section('title')
    {{ __('create') . ' ' . __('player') }}
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
                        <li class="breadcrumb-item active"><i
                                class="nav-icon fas fa-user-edit mr-1"></i>{{ __('create') . ' ' . __('player') }}
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
                            <h3 class="card-title">{{ __('create') . ' ' . __('player') }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('players') }}" role="form" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <!-- Tournament -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Tournament</label>
                                            <select name="tournament_id" id="tournament_id"
                                                class="form-control required-field @error('tournament_id') is-invalid @enderror">
                                                <option value="">Select Tournament</option>
                                                @foreach ($tournaments as $tournament)
                                                    <option value="{{ $tournament->id }}"
                                                        data-short-code="{{ $tournament->short_code }}"
                                                        {{ old('tournament_id') == $tournament->id ? 'selected' : '' }}>
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
                                                        {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                                        {{ $team->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('team_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Player Number (auto-generated, readonly) -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Player Number</label>
                                            <input type="text" name="player_number" id="player_number"
                                                value="{{ old('player_number') }}"
                                                class="form-control @error('player_number') is-invalid @enderror"
                                                placeholder="Select tournament to auto-generate" readonly>

                                            <small class="text-muted">Auto-generated from tournament short code</small>

                                            @error('player_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Player Name -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Player Name</label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control required-field @error('name') is-invalid @enderror"
                                                placeholder="Enter player name">

                                            <span class="error-message text-danger"></span>

                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Role -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Role</label>
                                            <select name="role"
                                                class="form-control required-field @error('role') is-invalid @enderror">
                                                <option value="">Select Role</option>
                                                <option value="batsman" {{ old('role') == 'batsman' ? 'selected' : '' }}>
                                                    Batsman</option>
                                                <option value="bowler" {{ old('role') == 'bowler' ? 'selected' : '' }}>
                                                    Bowler</option>
                                                <option value="wicket_keeper"
                                                    {{ old('role') == 'wicket_keeper' ? 'selected' : '' }}>Wicket Keeper
                                                </option>
                                                <option value="all_rounder"
                                                    {{ old('role') == 'all_rounder' ? 'selected' : '' }}>All-Rounder
                                                </option>
                                            </select>

                                            <span class="error-message text-danger"></span>

                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Bowling Style -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Bowling Style</label>
                                            <select name="bowling_style"
                                                class="form-control required-field @error('bowling_style') is-invalid @enderror">
                                                <option value="na"
                                                    {{ old('bowling_style') == 'na' ? 'selected' : '' }}>N/A</option>
                                                <option value="right"
                                                    {{ old('bowling_style') == 'right' ? 'selected' : '' }}>Right</option>
                                                <option value="left"
                                                    {{ old('bowling_style') == 'left' ? 'selected' : '' }}>Left</option>
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
                                            <input type="text" name="city" value="{{ old('city') }}"
                                                class="form-control @error('city') is-invalid @enderror"
                                                placeholder="Enter city">

                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Batting Style (Dropdown) -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Batting Style</label>
                                            <select name="batting_style"
                                                class="form-control required-field @error('batting_style') is-invalid @enderror">
                                                <option value="">Select Batting Style</option>
                                                <option value="right_handed"
                                                    {{ old('batting_style') == 'right_handed' ? 'selected' : '' }}>
                                                    Right Handed</option>
                                                <option value="left_handed"
                                                    {{ old('batting_style') == 'left_handed' ? 'selected' : '' }}>
                                                    Left Handed</option>
                                            </select>

                                            <span class="error-message text-danger"></span>

                                            @error('batting_style')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Base Price -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Base Price</label>
                                            <input type="text" name="base_price" value="{{ old('base_price') }}"
                                                class="form-control @error('base_price') is-invalid @enderror"
                                                placeholder="Enter base price">

                                            @error('base_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Sold Price -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sold Price</label>
                                            <input type="text" name="sold_price" value="{{ old('sold_price') }}"
                                                class="form-control @error('sold_price') is-invalid @enderror"
                                                placeholder="Enter sold price">

                                            @error('sold_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Player Status -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Player Status</label>
                                            <select name="player_status"
                                                class="form-control required-field @error('player_status') is-invalid @enderror">
                                                <option value="pending"
                                                    {{ old('player_status', 'pending') == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="unsold"
                                                    {{ old('player_status', 'unsold') == 'unsold' ? 'selected' : '' }}>
                                                    Unsold</option>
                                                <option value="sold"
                                                    {{ old('player_status') == 'sold' ? 'selected' : '' }}>Sold</option>
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
                                            <label class="required">Payment Status</label>
                                            <select name="payment_status"
                                                class="form-control required-field @error('payment_status') is-invalid @enderror">
                                                <option value="not_paid"
                                                    {{ old('payment_status', 'not_paid') == 'not_paid' ? 'selected' : '' }}>
                                                    Not Paid</option>
                                                <option value="paid"
                                                    {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                                </option>
                                            </select>

                                            <span class="error-message text-danger"></span>

                                            @error('payment_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3" placeholder="Player description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Payment Reference -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Reference / UTR (Optional)</label>
                                            <input type="text" name="payment_reference"
                                                value="{{ old('payment_reference') }}"
                                                class="form-control @error('payment_reference') is-invalid @enderror"
                                                placeholder="Enter UTR or transaction ID">
                                            @error('payment_reference')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Player Photo (required) -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Player Photo</label>
                                            <input name="photo" type="file" accept="image/*"
                                                class="filepond required-file">
                                            @error('photo')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Payment Screenshot (required) -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Payment Screenshot</label>
                                            <input name="payment_screenshot" type="file"
                                                class="filepond required-file">
                                            @error('payment_screenshot')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Original Proof (required) -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Original Proof</label>
                                            <input name="original_proof" type="file" class="filepond required-file">
                                            @error('original_proof')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <div class="form-group mt-4">
                                            <div class="form-check form-switch d-flex align-items-center">
                                                <label class="mr-2">Active / Inactive</label>
                                                <input class="form-check-input me-2 status-switch" type="checkbox"
                                                    id="status" name="status" checked>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="col-md-12 text-right">
                                        <a href="{{ url('players') }}" class="btn btn-default" style="padding:7px">
                                            <i class="fas fa-arrow-left"></i>
                                            {{ __('back') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i>
                                            {{ __('submit') }}
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

            if (tournamentSelect) {
                tournamentSelect.addEventListener('change', function() {
                    const tournamentId = this.value;

                    if (!tournamentId) {
                        playerNumberInput.value = '';
                        return;
                    }

                    playerNumberInput.value = 'Loading...';

                    fetch(`{{ route('players.generate-number') }}?tournament_id=${tournamentId}`, {
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

                if (tournamentSelect.value && !playerNumberInput.value) {
                    tournamentSelect.dispatchEvent(new Event('change'));
                }
            }
        });
    </script>
@endsection
