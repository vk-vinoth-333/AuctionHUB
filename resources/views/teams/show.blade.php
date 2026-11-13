@extends('layouts.main')

@section('title')
    {{ __('team_details') }}
@endsection

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('team_details') }}</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('home') }}" class="text-dark">
                                <i class="fas fa-home mr-1"></i>{{ __('dashboard') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item text-dark">
                            <a href="{{ url('teams') }}" class="text-dark">
                                <i class="fas fa-users mr-1"></i>{{ __('teams') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            <i class="fas fa-info-circle mr-1"></i>{{ __('team_details') }}
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
                        {{ $team->name }}
                        @if($team->short_name)
                            ( {{ $team->short_name }} )
                        @endif
                    </h3>
                </div>


                <div class="card-body">

                    <div class="row">

                        <!-- Team Logo -->
                        <div class="col-md-4 text-center mt-3">

                            @if($team->logo)
                                <img src="{{ asset('storage/' . $team->logo) }}" class="img-fluid rounded shadow">
                            @else
                                <span class="text-muted">No Logo</span>
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
                                            <span class="info-box-text">Tournament</span>
                                            <span class="info-box-number">
                                                {{ $team->tournament->name ?? 'N/A' }}
                                            </span>
                                        </div>

                                    </div>
                                </div>


                                <!-- Owner -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">

                                        <span class="info-box-icon bg-green-new">
                                            <i class="fas fa-user text-green-new"></i>
                                        </span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Owner</span>
                                            <span class="info-box-number">
                                                {{ $team->owner_name ?? 'N/A' }}
                                            </span>
                                        </div>

                                    </div>
                                </div>


                                <!-- Email -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">

                                        <span class="info-box-icon bg-purple-new">
                                            <i class="fas fa-envelope text-purple-new"></i>
                                        </span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Email</span>
                                            <span class="info-box-number">
                                                {{ $team->contact_email ?? 'N/A' }}
                                            </span>
                                        </div>

                                    </div>
                                </div>


                                <!-- Phone -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">

                                        <span class="info-box-icon bg-orange-new">
                                            <i class="fas fa-phone text-orange-new"></i>
                                        </span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Phone</span>
                                            <span class="info-box-number">
                                                {{ $team->contact_phone ?? 'N/A' }}
                                            </span>
                                        </div>

                                    </div>
                                </div>


                                <!-- Status -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">

                                        <span class="info-box-icon {{ $team->status ? 'bg-green-new' : 'bg-red-new' }}">
                                            <i
                                                class="fas fa-power-off {{ $team->status ? 'text-green-new' : 'text-red-new' }}"></i>
                                        </span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Status</span>
                                            <span class="info-box-number">

                                                {{ $team->status ? 'Active' : 'Inactive' }}

                                            </span>
                                        </div>

                                    </div>
                                </div>


                                @if($team->description)

                                    <!-- Description -->
                                    <div class="col-md-6 col-12">

                                        <div class="info-box">

                                            <span class="info-box-icon bg-pink-new">
                                                <i class="fas fa-align-left text-pink-new"></i>
                                            </span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Description</span>
                                                <span class="info-box-number">
                                                    {{ $team->description }}
                                                </span>
                                            </div>

                                        </div>

                                    </div>

                                @endif


                            </div>


                            <!-- Buttons -->

                            <div class="text-right mt-3">

                                <a href="{{ url('teams') }}" class="btn btn-default">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>

                                <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-primary">
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