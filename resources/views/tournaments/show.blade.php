@extends('layouts.main')

@section('title')
    {{ __('tournament_details') }}
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
                        <li class="breadcrumb-item active"><i
                                class="nav-icon fas fa-newspaper mr-1"></i>{{ __('tournament_details') }}
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
                    <h3 class="card-title">{{ $tournament->name }} ( {{ $tournament->short_code }} )</h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <!-- Logo -->
                        <div class="col-md-4 text-center mt-3">
                            @if($tournament->logo)
                                <img src="{{ asset('storage/' . $tournament->logo) }}" class="img-fluid rounded shadow">
                            @else
                                <span class="text-muted">No Logo</span>
                            @endif
                        </div>

                        <div class="col-md-8">


                            <div class="row">

                                <!-- Organizer -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-blue-new">
                                            <i class="fas fa-user text-blue-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Organizer</span>
                                            <span class="info-box-number">
                                                {{ $tournament->organizer->name ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Venue -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-green-new">
                                            <i class="fas fa-map-marker-alt text-green-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Venue</span>
                                            <span class="info-box-number">
                                                {{ $tournament->venue }}, {{ $tournament->city }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-purple-new">
                                            <i class="fas fa-calendar text-purple-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Tournament Dates</span>
                                            <span class="info-box-number">
                                                {{ \Carbon\Carbon::parse($tournament->start_date)->format('d M Y') }}
                                                —
                                                {{ \Carbon\Carbon::parse($tournament->end_date)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Teams -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-orange-new">
                                            <i class="fas fa-users text-orange-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Teams</span>
                                            <span class="info-box-number">
                                                {{ $tournament->total_teams }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Prize -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-pink-new">
                                            <i class="fas fa-trophy text-pink-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Prize Amount</span>
                                            <span class="info-box-number">
                                                ₹ {{ number_format($tournament->prize_amount) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Registration -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-sky-new">
                                            <i class="fas fa-ticket-alt text-sky-new"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Registration</span>
                                            <span class="info-box-number">
                                                @if($tournament->is_pr_free)
                                                    Free
                                                @else
                                                    ₹ {{ number_format($tournament->pr_amount) }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span
                                            class="info-box-icon {{ $tournament->status ? 'bg-green-new' : 'bg-red-new' }}">
                                            <i
                                                class="fas fa-power-off {{ $tournament->status ? 'text-green-new' : 'text-red-new' }}"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Status</span>
                                            <span class="info-box-number">
                                                {{ $tournament->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if($tournament->description)
                                    <!-- Description -->
                                    <div class="col-md-6 col-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-blue-new">
                                                <i class="fas fa-align-left text-blue-new"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Description</span>
                                                <span class="info-box-number">
                                                    {{ $tournament->description }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <!-- Buttons -->
                            <div class="text-right mt-3">
                                <a href="{{ url('tournaments') }}" class="btn btn-default">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <a href="{{ route('tournaments.edit', $tournament->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>

                        </div>


                    </div>

                </div>
            </div>

        </div>
    </section>

@endsection