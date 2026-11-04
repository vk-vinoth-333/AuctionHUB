@extends('layouts.main')

@section('title')
    {{ __('create') . ' ' . __('tournaments') }}
@endsection

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('create') . ' ' . __('tournament') }}</h1>
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
                                class="nav-icon fas fa-newspaper mr-1"></i>{{ __('create') . ' ' . __('tournament') }}
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
                            <h3 class="card-title">{{ __('create') . ' ' . __('tournament') }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('tournaments') }}" role="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <!-- Tournament Name -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'tournament_name') }}</label>
                                            <input type="text" name="name"
                                                class="form-control required-field @error('name') is-invalid @enderror"
                                                placeholder="Enter tournament name">
                                            <span class="error-message text-danger"></span>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Short Code -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'tournament_short_code') }}</label>
                                            <input type="text" name="short_code"
                                                class="form-control required-field @error('short_code') is-invalid @enderror"
                                                placeholder="Enter tournament Short Code">
                                            <span class="error-message text-danger"></span>
                                            @error('short_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Organizer -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'organizer') }}</label>
                                            <select name="organizer_id"
                                                class="form-control required-field @error('organizer_id') is-invalid @enderror">
                                                <option value="">Select Organizer</option>
                                                @foreach($organizers as $organizer)
                                                    <option value="{{ $organizer->id }}">
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

                                    <!-- Total Teams -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'total_teams') }}</label>
                                            <input type="number" name="total_teams"
                                                class="form-control required-field @error('total_teams') is-invalid @enderror"
                                                min="0">
                                            <span class="error-message text-danger"></span>
                                            @error('total_teams')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __(key: 'description') }}</label>
                                            <textarea name="description" class="form-control" rows="3"
                                                placeholder="Tournament description"></textarea>
                                        </div>
                                    </div>

                                    <!-- Logo Upload -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('logo') }}</label>
                                            <input name="file" type="file" accept="image/*" class="filepond">
                                        </div>
                                    </div>

                                    <!-- Start Date -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'start_date') }}</label>
                                            <input type="date" name="start_date"
                                                class="form-control required-field @error('start_date') is-invalid @enderror restrict-past-date">
                                            <span class="error-message text-danger"></span>
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- End Date -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'end_date') }}</label>
                                            <input type="date" name="end_date"
                                                class="form-control required-field @error('end_date') is-invalid @enderror restrict-past-date">
                                            <span class="error-message text-danger"></span>
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Venue -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'venue') }}</label>
                                            <input type="text" name="venue"
                                                class="form-control required-field @error('venue') is-invalid @enderror"
                                                placeholder="Enter venue">
                                            <span class="error-message text-danger"></span>
                                            @error('venue')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- City -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="required">{{ __(key: 'city') }}</label>
                                            <input type="text" name="city"
                                                class="form-control required-field @error('city') is-invalid @enderror"
                                                placeholder="Enter city">
                                            <span class="error-message text-danger"></span>
                                            @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Prize Amount -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __(key: 'total_prize_amount') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">₹</span>
                                                </div>
                                                <input type="number" name="prize_amount" class="form-control"
                                                    placeholder="Enter prize amount">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Active or Inactive -->
                                    <div class="col-md-4">
                                        <div class="form-group mt-4">
                                            <div class="form-check form-switch d-flex align-items-center">
                                                <label class="mr-2">{{ __('active_or_inactive') }}</label>
                                                <input class="form-check-input me-2 status-switch" type="checkbox"
                                                    id="status" name="status">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Player Registration Free -->
                                    <div class="col-md-4">
                                        <div class="form-group mt-4">
                                            <div class="form-check form-switch d-flex align-items-center">
                                                <label class="mr-2">{{ __('player_registration_free') }}</label>
                                                <input class="form-check-input me-2 status-switch" type="checkbox"
                                                    id="is_pr_free" name="is_pr_free">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Player Registration Amount -->
                                    <div class="col-md-4" id="pr_amount_group" style="display: none;">
                                        <div class="form-group">
                                            <label class="required">{{ __('player_registration_amount') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">₹</span>
                                                </div>
                                                <input type="number" name="pr_amount" id="pr_amount" class="form-control"
                                                    placeholder="Enter player registration amount" min="0">
                                            </div>
                                            <span class="error-message text-danger"></span>
                                            @error('pr_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <!-- Submit -->
                                    <div class="col-md-12 text-right">
                                        <a href="{{ url('tournaments') }}" class="btn btn-default" style="padding:7px">
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
        document.addEventListener('DOMContentLoaded', function () {

            //player registration amount checkbox
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

            const checkbox = document.getElementById('is_pr_free');
            const prAmountGroup = document.getElementById('pr_amount_group');
            const prAmountInput = document.getElementById('pr_amount');

            function togglePRAmount() {

                if (checkbox.checked) {

                    prAmountGroup.style.display = 'none';

                    prAmountInput.classList.remove('required-field');

                    prAmountInput.value = '';
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