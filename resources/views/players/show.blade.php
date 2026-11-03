@extends('layouts.main')

@section('title')
    {{ __('player_details') }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('player_details') }}</h1>
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
                                class="nav-icon fas fa-user-friends mr-1"></i>{{ __('player_details') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-secondary">

                <div class="card-header">
                    <h3 class="card-title">
                        {{ $player->name }}
                        @if ($player->player_number)
                            ( {{ $player->player_number }} )
                        @endif
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <!-- Photo -->
                        <div class="col-md-4 text-center mt-3">
                            @if ($player->photo)
                                <img src="{{ asset('storage/' . $player->photo) }}" class="img-fluid rounded shadow"
                                    style="max-height: 250px;">
                            @else
                                <span class="text-muted">No Photo</span>
                            @endif
                        </div>

                        <div class="col-md-8">

                            <div class="row">

                                <!-- Tournament -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-blue-new">
                                            <i class="fas fa-trophy text-blue-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('tournament') }}</span>
                                            <span class="info-box-number">
                                                {{ $player->tournament->name ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Team -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-green-new">
                                            <i class="fas fa-users text-green-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('team') }}</span>
                                            <span class="info-box-number">
                                                {{ $player->team->name ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Player Number -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-purple-new">
                                            <i class="fas fa-hashtag text-purple-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('player_number') }}</span>
                                            <span class="info-box-number">
                                                {{ $player->player_number ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-orange-new">
                                            <i class="fas fa-baseball-ball text-orange-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('role') }}</span>
                                            <span class="info-box-number">
                                                {{ $player->detail->role_label ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Batting Style -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-pink-new">
                                            <i class="fas fa-hand-rock text-pink-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('batting_style') }}</span>
                                            <span class="info-box-number">
                                                @if (($player->detail->batting_style ?? null) === 'right_handed')
                                                    {{ __('right_handed') }}
                                                @elseif(($player->detail->batting_style ?? null) === 'left_handed')
                                                    {{ __('left_handed') }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bowling Style -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-sky-new">
                                            <i class="fas fa-bullseye text-sky-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('bowling_style') }}</span>
                                            <span class="info-box-number">
                                                {{ $player->bowling_style_label }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-blue-new">
                                            <i class="fas fa-map-marker-alt text-blue-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('city') }}</span>
                                            <span class="info-box-number">
                                                {{ $player->detail->city ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Base Price -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-green-new">
                                            <i class="fas fa-tag text-green-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('base_price') }}</span>
                                            <span class="info-box-number">
                                                @if ($player->detail->base_price ?? null)
                                                    ₹ {{ number_format((float) $player->detail->base_price) }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sold Price -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-purple-new">
                                            <i class="fas fa-gavel text-purple-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('sold_price') }}</span>
                                            <span class="info-box-number">
                                                @if ($player->detail->sold_price ?? null)
                                                    ₹ {{ number_format((float) $player->detail->sold_price) }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Player Status (Sold / Unsold) -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span
                                            class="info-box-icon {{ $player->player_status === 'sold' ? 'bg-green-new' : 'bg-orange-new' }}">
                                            <i
                                                class="fas fa-check-circle {{ $player->player_status === 'sold' ? 'text-green-new' : 'text-orange-new' }}"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('player_status') }}</span>
                                            <span class="info-box-number">
                                                {{ $player->player_status === 'sold' ? __('sold') : __('unsold') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Status (Paid / Not Paid) -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span
                                            class="info-box-icon {{ $player->payment_status === 'paid' ? 'bg-green-new' : 'bg-red-new' }}">
                                            <i
                                                class="fas fa-wallet {{ $player->payment_status === 'paid' ? 'text-green-new' : 'text-red-new' }}"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('payment_status') }}</span>
                                            <span class="info-box-number">
                                                {{ $player->payment_status === 'paid' ? __('paid') : __('not_paid') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Active Status -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon {{ $player->status ? 'bg-green-new' : 'bg-red-new' }}">
                                            <i
                                                class="fas fa-power-off {{ $player->status ? 'text-green-new' : 'text-red-new' }}"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('status') }}</span>
                                            <span class="info-box-number">
                                                {{ $player->status ? __('active') : __('inactive') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if ($player->description)
                                    <div class="col-md-6 col-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-blue-new">
                                                <i class="fas fa-align-left text-blue-new"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{ __('description') }}</span>
                                                <span class="info-box-number">
                                                    {{ $player->description }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <!-- Documents Section -->
                            <div class="row mt-2">

                                <!-- Original Proof -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-sky-new">
                                            <i class="fas fa-file-alt text-sky-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('original_proof') }}</span>
                                            <span class="info-box-number">
                                                @if ($player->detail->original_proof ?? null)
                                                    <a href="{{ asset('storage/' . $player->detail->original_proof) }}"
                                                        target="_blank" class="text-primary">
                                                        <i class="fas fa-eye"></i> {{ __('view') }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Screenshot -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-green-new">
                                            <i class="fas fa-receipt text-green-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ __('payment_screenshot') }}</span>
                                            <span class="info-box-number">
                                                @if ($player->detail->payment_screenshot ?? null)
                                                    <a href="{{ asset('storage/' . $player->detail->payment_screenshot) }}"
                                                        target="_blank" class="text-primary">
                                                        <i class="fas fa-eye"></i> {{ __('view') }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Buttons -->
                            <div class="text-right mt-3">
                                <a href="{{ url('players') }}" class="btn btn-default">
                                    <i class="fas fa-arrow-left"></i> {{ __('back') }}
                                </a>
                                <a href="{{ route('players.edit', $player->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> {{ __('edit') }}
                                </a>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
