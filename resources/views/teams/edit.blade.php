@extends('layouts.main')

@section('title')
    {{ __('edit') . ' ' . __('team') }}
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
                                <i class="fas fa-tachometer-alt mr-1"></i>{{ __('dashboard') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item text-dark">
                            <a href="{{ url('teams') }}" class="text-dark">
                                <i class="fas fa-users mr-1"></i>{{ __('teams') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item active brand-red">
                            <i class="fas fa-pen mr-1"></i>{{ __('edit') }}
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
                            <h3 class="card-title">{{ __('edit') . ' ' . __('team') }}</h3>
                        </div>

                        <div class="card-body">

                            <form action="{{ url('teams/' . $team->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    <!-- Tournament -->
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label class="required">Tournament</label>

                                            <select name="tournament_id"
                                                class="form-control required-field @error('tournament_id') is-invalid @enderror">

                                                <option value="">Select Tournament</option>

                                                @foreach ($tournaments as $tournament)
                                                    <option value="{{ $tournament->id }}"
                                                        {{ $team->tournament_id == $tournament->id ? 'selected' : '' }}>

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


                                    <!-- Team Name -->
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label class="required">Team Name</label>

                                            <input type="text" name="name" value="{{ old('name', $team->name) }}"
                                                class="form-control required-field @error('name') is-invalid @enderror"
                                                placeholder="Enter team name">

                                            <span class="error-message text-danger"></span>

                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>


                                    <!-- Short Name -->
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label>Short Name</label>

                                            <input type="text" name="short_name" maxlength="20"
                                                value="{{ old('short_name', $team->short_name) }}"
                                                class="form-control @error('short_name') is-invalid @enderror"
                                                placeholder="Enter short name">

                                            @error('short_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>


                                    <!-- Owner Name -->
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label>Owner Name</label>

                                            <input type="text" name="owner_name"
                                                value="{{ old('owner_name', $team->owner_name) }}"
                                                class="form-control @error('owner_name') is-invalid @enderror"
                                                placeholder="Enter owner name">

                                            @error('owner_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>


                                    <!-- Contact Email -->
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label>Contact Email</label>

                                            <input type="email" name="contact_email"
                                                value="{{ old('contact_email', $team->contact_email) }}"
                                                class="form-control @error('contact_email') is-invalid @enderror"
                                                placeholder="Enter email">

                                            @error('contact_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>


                                    <!-- Contact Phone -->
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label>Contact Phone</label>

                                            <input type="text" name="contact_phone"
                                                value="{{ old('contact_phone', $team->contact_phone) }}"
                                                class="form-control @error('contact_phone') is-invalid @enderror"
                                                placeholder="Enter phone number">

                                            @error('contact_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>


                                    <!-- Description -->
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label>Description</label>

                                            <textarea name="description" class="form-control" rows="3" placeholder="Team description">{{ old('description', $team->description) }}</textarea>

                                        </div>
                                    </div>


                                    <!-- Logo -->
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label>Team Logo</label>

                                            <input name="file" type="file" accept="image/*" class="filepond">

                                            @if ($team->logo)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $team->logo) }}" width="100">
                                                </div>
                                            @endif

                                        </div>
                                    </div>


                                    <!-- Status -->
                                    <div class="col-md-4">

                                        <div class="form-group mt-4">

                                            <div class="form-check form-switch d-flex align-items-center">

                                                <label class="mr-2">Active / Inactive</label>

                                                <input class="form-check-input status-switch" type="checkbox"
                                                    name="status" id="status" {{ $team->status ? 'checked' : '' }}>

                                            </div>

                                        </div>

                                    </div>


                                    <!-- Buttons -->
                                    <div class="col-md-12 text-right">

                                        <a href="{{ url('teams') }}" class="btn btn-default" style="padding:7px">
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

        });
    </script>
@endsection
