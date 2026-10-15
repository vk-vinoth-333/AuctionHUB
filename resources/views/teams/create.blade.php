@extends('layouts.main')

@section('title')
    {{ __('create') . ' ' . __('teams') }}
@endsection

@section('content')

    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('create') . ' ' . __('tournament') }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('teams') }}" role="form" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <!-- Tournament -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">Tournament</label>
                                            <select name="tournament_id"
                                                class="form-control required-field @error('tournament_id') is-invalid @enderror">
                                                <option value="">Select Tournament</option>

                                                @foreach($tournaments as $tournament)
                                                    <option value="{{ $tournament->id }}">
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

                                            <input type="text" name="name"
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

                                            <textarea name="description" class="form-control" rows="3"
                                                placeholder="Team description"></textarea>
                                        </div>
                                    </div>


                                    <!-- Logo -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Team Logo</label>

                                            <input name="file" type="file" accept="image/*" class="filepond">
                                        </div>
                                    </div>


                                    <!-- Status -->
                                    <div class="col-md-4">
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

                                        <a href="{{ url('teams') }}" class="btn btn-default" style="padding:7px">

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
        document.addEventListener('DOMContentLoaded', function () {

            //team active/inactive checkbox
            var elems = Array.prototype.slice.call(document.querySelectorAll(".status-switch"));
            elems.forEach(function (elem) {
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