@extends('layouts.main')

@section('title')
    {{ __('edit') . ' ' . __('tournaments') }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('edit') . ' ' . __('tournament') }}</h1>
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
                                class="nav-icon fas fa-newspaper mr-1"></i>{{ __('edit') . ' ' . __('tournament') }}
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
                            <h3 class="card-title">{{ __('edit') . ' ' . __('tournament') }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tournaments.update', $tournament->id) }}" role="form" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <!-- Section 1: Basic Info -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'tournament_name') }}</label>
                                            <input type="text" name="name" class="form-control required-field"
                                                placeholder="Enter tournament name"
                                                value="{{ old('name', $tournament->name) }}">
                                            <span class="error-message text-danger"></span>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'tournament_short_code') }}</label>
                                            <input type="text" name="short_code" class="form-control required-field"
                                                placeholder="Enter tournament Short Code"
                                                value="{{ old('short_code', $tournament->short_code) }}">
                                            <span class="error-message text-danger"></span>
                                            @error('short_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'organizer') }}</label>
                                            <select name="organizer_id" class="form-control required-field">
                                                <option value="">Select Organizer</option>
                                                @foreach ($organizers as $organizer)
                                                    <option value="{{ $organizer->id }}"
                                                        {{ $tournament->organizer_id == $organizer->id ? 'selected' : '' }}>
                                                        {{ $organizer->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="error-message text-danger"></span>
                                            @error('organizer_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Section 2: Logistics -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'venue') }}</label>
                                            <input type="text" name="venue" class="form-control required-field"
                                                placeholder="Enter venue" value="{{ $tournament->venue }}">
                                            <span class="error-message text-danger"></span>
                                            @error('venue')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'city') }}</label>
                                            <input type="text" name="city" class="form-control required-field"
                                                placeholder="Enter city" value="{{ $tournament->city }}">
                                            <span class="error-message text-danger"></span>
                                            @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __(key: 'total_prize_amount') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">₹</span>
                                                </div>
                                                <input type="number" name="prize_amount" class="form-control"
                                                    placeholder="Enter prize amount"
                                                    value="{{ $tournament->prize_amount }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'start_date') }}</label>
                                            <input type="date" name="start_date"
                                                class="form-control required-field restrict-past-date"
                                                value="{{ $tournament->start_date }}">
                                            <span class="error-message text-danger"></span>
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'end_date') }}</label>
                                            <input type="date" name="end_date"
                                                class="form-control required-field restrict-past-date"
                                                value="{{ $tournament->end_date }}">
                                            <span class="error-message text-danger"></span>
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('logo') }}</label>
                                            <input name="file" type="file" accept="image/*" class="filepond">
                                            @if ($tournament->logo)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $tournament->logo) }}" width="80"
                                                        >
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Section 3: Auction Rules -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'total_teams') }}</label>
                                            <input type="number" name="total_teams" class="form-control required-field"
                                                min="0"
                                                value="{{ old('total_teams', $tournament->total_teams) }}">
                                            <span class="error-message text-danger"></span>
                                            @error('total_teams')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Total Pools -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Total Pools (Groups)</label>
                                            <input type="number" name="total_pools" class="form-control required-field" 
                                                value="{{ old('total_pools', $tournament->total_pools ?? 2) }}" min="1">
                                            <small class="text-muted">e.g. 2 for Pool A & B</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Players Per Team</label>
                                            <input type="number" name="players_per_team"
                                                value="{{ old('players_per_team', $tournament->players_per_team ?? 11) }}"
                                                class="form-control required-field @error('players_per_team') is-invalid @enderror"
                                                min="1">
                                            <span class="error-message text-danger"></span>
                                            @error('players_per_team')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Base Point (Per Player)</label>
                                            <input type="number" name="base_point"
                                                value="{{ old('base_point', $tournament->base_point ?? 1000) }}"
                                                class="form-control required-field @error('base_point') is-invalid @enderror"
                                                min="0">
                                            <span class="error-message text-danger"></span>
                                            @error('base_point')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Section 4: Registration Rules -->
                                    <div class="col-md-4">
                                        <div class="form-group mt-4">
                                            <div class="form-check form-switch d-flex align-items-center">
                                                <label class="mr-2">{{ __('player_registration_free') }}</label>
                                                <input class="form-check-input me-2 status-switch" type="checkbox"
                                                    id="is_pr_free" name="is_pr_free"
                                                    {{ $tournament->is_pr_free ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="pr_amount_group" style="display: none;">
                                        <div class="form-group">
                                            <label class="required">{{ __('player_registration_amount') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">₹</span>
                                                </div>
                                                <input type="number" name="pr_amount" id="pr_amount"
                                                    class="form-control" placeholder="Enter amount" min="0"
                                                    value="{{ $tournament->pr_amount }}">
                                            </div>
                                            <span class="error-message text-danger"></span>
                                            @error('pr_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>UPI ID</label>
                                            <input type="text" name="upi_id" class="form-control"
                                                placeholder="e.g. tournament@upi"
                                                value="{{ old('upi_id', $tournament->upi_id) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Contact Phone Number</label>
                                            <input type="text" name="contact_phone" class="form-control"
                                                placeholder="e.g. 9876543210"
                                                value="{{ old('contact_phone', $tournament->contact_phone) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Payment QR Code</label>
                                            <input name="payment_qr_code" type="file" accept="image/*"
                                                class="filepond">
                                            @if ($tournament->payment_qr_code)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $tournament->payment_qr_code) }}"
                                                        width="80" >
                                                    <small class="text-muted d-block mt-1">Current QR</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mt-4">
                                            <div class="form-check form-switch d-flex align-items-center">
                                                <label class="mr-2">Registration Open</label>
                                                <input class="form-check-input me-2 status-switch" type="checkbox"
                                                    id="registration_open" name="registration_open"
                                                    {{ $tournament->registration_open ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Registration Ends At</label>
                                            <input type="datetime-local" name="registration_ends_at"
                                                class="form-control @error('registration_ends_at') is-invalid @enderror"
                                                value="{{ old('registration_ends_at', $tournament->registration_ends_at ? \Carbon\Carbon::parse($tournament->registration_ends_at)->format('Y-m-d\TH:i') : '') }}">
                                            <small class="text-muted">Leave empty for no deadline</small>
                                            @error('registration_ends_at')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mt-4">
                                            <div class="form-check form-switch d-flex align-items-center">
                                                <label class="mr-2">{{ __('active_or_inactive') }}</label>
                                                <input class="form-check-input me-2 status-switch" type="checkbox"
                                                    id="status" name="status"
                                                    {{ $tournament->status ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __(key: 'description') }}</label>
                                            <textarea name="description" class="form-control" rows="3" placeholder="Tournament description">{{ old('description', $tournament->description) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="col-md-12 text-right mt-3 border-top pt-3">
                                        <a href="{{ url('tournaments') }}" class="btn btn-default">
                                            <i class="fas fa-arrow-left"></i> {{ __(key: 'back') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> {{ __(key: 'submit') }}
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

            const checkbox = document.getElementById('is_pr_free');
            const prAmountGroup = document.getElementById('pr_amount_group');
            const prAmountInput = document.getElementById('pr_amount');

            function togglePRAmount() {
                if (checkbox.checked) {
                    prAmountGroup.style.display = 'none';
                    prAmountInput.classList.remove('required-field');
                    prAmountInput.classList.remove('is-invalid');
                    const errorSpan = prAmountGroup.querySelector('.error-message');
                    if (errorSpan) errorSpan.textContent = '';
                } else {
                    prAmountGroup.style.display = 'block';
                    prAmountInput.classList.add('required-field');
                }
            }

            togglePRAmount();
            checkbox.addEventListener('change', togglePRAmount);
        });
    </script>
@endsection
