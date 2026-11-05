<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Registration - {{ $tournament->name }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">

    <style>
        :root {
            --brand: #be212a;
            --brand-dark: #9a1a22;
            --slate: #1e293b;
            --line: #e3e8ef;
        }

        body {
            background: #f4f6f9;
            font-family: 'Inter', sans-serif;
            color: #1f2937;
        }

        /* ---------- Hero ---------- */
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, var(--slate) 55%, #3b0f13 100%);
            color: #fff;
            padding: 56px 0 96px;
            position: relative;
            overflow: hidden;
        }

        .hero::before,
        .hero::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, .06);
        }

        .hero::before {
            width: 420px;
            height: 420px;
            right: -120px;
            top: -160px;
        }

        .hero::after {
            width: 260px;
            height: 260px;
            right: 40px;
            top: -60px;
            border-color: rgba(190, 33, 42, .35);
        }

        .hero-in {
            display: flex;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .logo-box {
            flex: 0 0 132px;
            width: 132px;
            height: 132px;
            margin-right: 28px;
            background: #fff;
            border-radius: 22px;
            padding: 12px;
            display: grid;
            place-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .35);
            border: 3px solid rgba(255, 255, 255, .15);
        }

        .logo-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .logo-box i {
            font-size: 3rem;
            color: var(--brand);
        }

        @media (max-width: 767px) {
            .hero-in {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .logo-box {
                flex-basis: 96px;
                width: 96px;
                height: 96px;
                margin: 0 0 20px;
                border-radius: 18px;
            }
        }

        .hero .code {
            background: var(--brand);
            color: #fff;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: .85rem;
            display: inline-block;
        }

        .hero h1 {
            font-weight: 800;
            font-size: clamp(1.9rem, 4.5vw, 3rem);
            margin: 14px 0 8px;
            line-height: 1.15;
            word-break: break-word;
        }

        .hero p {
            color: #cbd5e1;
            max-width: 640px;
            margin: 0;
            word-break: break-word;
        }

        .closes {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .18);
            padding: 8px 14px;
            border-radius: 8px;
            font-size: .9rem;
        }

        .closes b {
            color: #fbbf24;
            font-variant-numeric: tabular-nums;
        }

        /* ---------- Tournament info cards ---------- */
        .info-wrap {
            margin-top: -62px;
            position: relative;
            z-index: 3;
        }

        .info-card {
            background: #fff;
            border: 0;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .1);
            padding: 16px;
            height: 100%;
            display: flex;
            align-items: flex-start; /* Align to top for long text */
        }

        .info-icon {
            flex: 0 0 46px;
            height: 46px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            margin-right: 14px;
        }

        .info-card .text-content {
            min-width: 0; /* Fixes flex overflow */
        }

        .info-card small {
            display: block;
            color: #6b7280;
            font-weight: 500;
            font-size: .75rem;
            margin-bottom: 2px;
        }

        .info-card strong {
            font-weight: 700;
            font-size: .95rem;
            line-height: 1.3;
            display: block;
            word-break: break-word; /* Fixes long text overflow */
        }

        .ic-red { background: #fde8ea; color: var(--brand); }
        .ic-blue { background: #e0ecff; color: #2563eb; }
        .ic-green { background: #dcfce7; color: #16a34a; }
        .ic-amber { background: #fef3c7; color: #d97706; }
        .ic-violet { background: #ede9fe; color: #7c3aed; }
        .ic-slate { background: #e2e8f0; color: #334155; }

        /* ---------- Form card ---------- */
        .card-secondary {
            border-top: 3px solid var(--brand);
        }

        .required:after {
            content: " *";
            color: var(--brand);
        }

        .sec {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.05rem;
            margin: 28px 0 16px;
        }

        .sec:first-of-type {
            margin-top: 4px;
        }

        .sec i {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #fde8ea;
            color: var(--brand);
            display: grid;
            place-items: center;
            margin-right: 10px;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .sec::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--line);
            margin-left: 14px;
        }

        .form-control-lg {
            font-size: 1rem;
            border-radius: 10px;
            border-color: #d5dbe5;
        }

        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .2rem rgba(190, 33, 42, .15);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            font-weight: 600;
            background: #f1f5f9;
            border-color: #d5dbe5;
        }

        .input-group>.form-control {
            border-radius: 0 10px 10px 0;
        }

        .err {
            color: var(--brand);
            font-size: .85rem;
            margin-top: 4px;
        }

        /* choice tiles (role / styles) */
        .tiles {
            display: flex;
            flex-wrap: wrap;
            margin: -5px;
        }

        .tile {
            position: relative;
            margin: 5px;
            flex: 1 1 100px;
        }

        .tile input {
            position: absolute;
            opacity: 0;
            inset: 0;
            cursor: pointer;
        }

        .tile span {
            display: block;
            text-align: center;
            padding: 14px 8px;
            border: 1.5px solid #d5dbe5;
            border-radius: 12px;
            background: #fff;
            font-weight: 600;
            font-size: .92rem;
            transition: all .15s;
            height: 100%;
        }

        .tile span i {
            display: block;
            font-size: 1.35rem;
            margin-bottom: 6px;
            color: #94a3b8;
            transition: color .15s;
        }

        .tile.sm span {
            padding: 11px 8px;
        }

        .tile input:hover+span {
            border-color: var(--brand);
        }

        .tile input:checked+span {
            border-color: var(--brand);
            background: #fff5f5;
            color: var(--brand-dark);
            box-shadow: 0 0 0 3px rgba(190, 33, 42, .12);
        }

        .tile input:checked+span i {
            color: var(--brand);
        }

        .tile input:focus-visible+span {
            outline: 3px solid #2563eb;
            outline-offset: 2px;
        }

        .filepond--root {
            margin-bottom: 0;
            font-family: 'Inter', sans-serif;
        }

        .filepond--panel-root {
            background: #f8fafc;
        }

        .hint {
            font-size: .8rem;
            color: #6b7280;
            margin-top: 6px;
        }

        .btn-primary {
            background: var(--brand);
            border-color: var(--brand);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--brand-dark);
            border-color: var(--brand-dark);
        }

        .btn-primary:disabled {
            opacity: .7;
        }

        /* ---------- Payment card ---------- */
        .pay {
            border-radius: 16px;
            background: var(--slate);
            color: #fff;
            top: 24px;
            z-index: 100;
            overflow: hidden;
        }

        .pay .qr {
            background: #fff;
            border-radius: 14px;
            padding: 12px;
            display: inline-block;
        }

        .pay .amt {
            font-weight: 800;
            font-size: 2.4rem;
            color: #fbbf24;
            line-height: 1;
        }

        .pay .row-d {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-top: 1px solid rgba(255, 255, 255, .1);
            font-size: .9rem;
            gap: 10px;
        }

        .pay .row-d span:first-child {
            color: #94a3b8;
            flex-shrink: 0;
        }

        .pay .row-d strong {
            word-break: break-word;
            text-align: right;
        }

        .copy {
            background: rgba(255, 255, 255, .12);
            border: 0;
            color: #fff;
            border-radius: 6px;
            font-size: .75rem;
            padding: 3px 9px;
            margin-left: 8px;
            flex-shrink: 0;
        }

        .pay ol {
            padding-left: 1.2rem;
            font-size: .88rem;
            color: #cbd5e1;
            line-height: 1.8;
            margin: 0;
        }

        /* ---------- States ---------- */
        .state {
            text-align: center;
            padding: 56px 24px;
        }

        .state .big {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            margin: 0 auto 18px;
            font-size: 2rem;
            color: #fff;
        }

        .pnum {
            display: inline-block;
            font-weight: 800;
            font-size: 2.2rem;
            letter-spacing: .02em;
            border: 2px dashed var(--brand);
            color: var(--brand);
            border-radius: 12px;
            padding: 6px 26px;
            margin: 14px 0;
        }

        .hp {
            position: absolute;
            left: -9999px;
            height: 0;
            overflow: hidden;
        }

        .upi-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            text-align: right;
            word-break: break-all;
            min-width: 0; 
        }

        .upi-container strong {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        /* ---- Responsive Ordering ---- */
        @media (max-width: 991px) {
            .pay-col {
                order: -1; /* Moves payment card to the top on mobile/tablet */
                margin-bottom: 1.5rem !important;
                position: static !important; /* Removes sticky behavior on mobile */
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }
    </style>
</head>

<body>

    {{-- ================= HERO ================= --}}
    <header class="hero">
        <div class="container hero-in">
            <div class="logo-box">
                @if ($tournament->logo)
                    <img src="{{ asset('storage/' . $tournament->logo) }}" alt="{{ $tournament->name }} logo" onerror="this.onerror=null; this.parentNode.innerHTML='<i class=\'fas fa-trophy\'></i>';">
                @else
                    <i class="fas fa-trophy"></i>
                @endif
            </div>
            <div class="hero-text">
                <span class="code"><i class="fas fa-hashtag mr-1"></i>{{ strtoupper($tournament->short_code) }}</span>
                <h1>{{ $tournament->name }}</h1>
                <p>{{ $tournament->description ?: 'Register as a player and get a chance to be picked in the auction.' }}
                </p>

                @if ($isOpen && $tournament->registration_ends_at)
                    <div class="closes"
                        data-end="{{ \Carbon\Carbon::parse($tournament->registration_ends_at)->toIso8601String() }}">
                        <i class="far fa-clock text-warning"></i> Registration closes in <b id="countdown">…</b>
                    </div>
                @endif
            </div>
        </div>
    </header>

    <div class="container info-wrap">
        {{-- ================= TOURNAMENT DETAIL CARDS ================= --}}
        <div class="row">
            @php
                $fmt = fn($d) => \Carbon\Carbon::parse($d)->format('d M Y');
                $cards = [];
                if ($tournament->start_date) {
                    $cards[] = [
                        'ic-red',
                        'fa-calendar-days',
                        'Dates',
                        $fmt($tournament->start_date) .
                        ($tournament->end_date ? ' - ' . $fmt($tournament->end_date) : ''),
                    ];
                }
                if ($tournament->venue || $tournament->city) {
                    $cards[] = [
                        'ic-blue',
                        'fa-location-dot',
                        'Venue',
                        collect([$tournament->venue, $tournament->city])
                            ->filter()
                            ->implode(', '),
                    ];
                }
                $cards[] = ['ic-green', 'fa-people-group', 'Teams', $tournament->total_teams ?: 'To be announced'];
                $cards[] = [
                    'ic-slate',
                    'fa-indian-rupee-sign',
                    'Registration fee',
                    $tournament->is_pr_free ? 'Free' : '₹ ' . $tournament->pr_amount,
                ];
            @endphp
            @foreach ($cards as [$cls, $icon, $label, $value])
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="info-card">
                        <div class="info-icon {{ $cls }}"><i class="fas {{ $icon }}"></i></div>
                        <div class="text-content"><small>{{ $label }}</small><strong>{{ $value }}</strong></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <main class="container pt-3 pb-5">

        @if (session('registered'))
            {{-- ================= SUCCESS ================= --}}
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-lg" style="border-radius:16px">
                        <div class="state">
                            <div class="big" style="background:#16a34a"><i class="fas fa-check"></i></div>
                            <h3 class="font-weight-bold">You're registered, {{ session('registered')['name'] }}!</h3>
                            <div class="pnum">{{ session('registered')['number'] }}</div>
                            <p class="mb-1 font-weight-600">Save this player number.</p>
                            <p class="text-muted mb-0">The admin will verify your payment and documents. We'll contact
                                you on the mobile number you entered.</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (!$isOpen)
            {{-- ================= CLOSED ================= --}}
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-lg" style="border-radius:16px">
                        <div class="state">
                            <div class="big" style="background:#64748b"><i class="fas fa-lock"></i></div>
                            <h3 class="font-weight-bold">Registration is closed</h3>
                            <p class="text-muted mb-0">{{ $tournament->name }} is not accepting new players right now.
                                Contact the organiser if you think this is a mistake.</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- ================= FORM ================= --}}
            <div class="row">

                {{-- Left (col-8) --}}
                <div class="col-lg-8 col-md-12 mb-4">
                    <div class="card card-secondary shadow-lg border-0" style="border-radius:16px;overflow:hidden">
                        <div class="card-header bg-dark text-white" style="padding:1.25rem 1.5rem">
                            <h3 class="card-title font-weight-bold m-0" style="font-size:1.25rem">
                                <i class="fas fa-user-plus mr-2 text-warning"></i> Register for {{ $tournament->name }}
                                <span class="badge badge-light ml-2 text-dark">{{ $tournament->short_code }}</span>
                            </h3>
                        </div>

                        <div class="card-body p-4">
                            @if (session('error'))
                                <div class="alert alert-danger"><i
                                        class="fas fa-circle-exclamation mr-1"></i>{{ session('error') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Please fix these and submit again:</strong>
                                    <ul class="mb-1 pl-3 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <small>Your files need to be selected again.</small>
                                </div>
                            @endif
                            <div class="alert alert-danger d-none" id="clientErr"></div>

                            <form id="regForm" action="{{ route('player.register.store', $tournament->short_code) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="hp" aria-hidden="true"><input type="text" name="website"
                                        tabindex="-1" autocomplete="off"></div>

                                <div class="sec"><i class="fas fa-id-badge"></i> Personal details</div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold required">Full Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            maxlength="100" autocomplete="name"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            placeholder="Enter full name" required>
                                        @error('name')
                                            <div class="err">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold required">Phone Number</label>
                                        <div class="input-group input-group-lg">
                                            <div class="input-group-prepend"><span class="input-group-text">+91</span>
                                            </div>
                                            <input type="tel" id="phone" name="phone"
                                                value="{{ old('phone') }}" inputmode="numeric" maxlength="14"
                                                autocomplete="tel"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                placeholder="10-digit mobile number" required>
                                        </div>
                                        @error('phone')
                                            <div class="err">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold required">City</label>
                                        <input type="text" name="city" value="{{ old('city') }}"
                                            maxlength="100" autocomplete="address-level2"
                                            class="form-control form-control-lg @error('city') is-invalid @enderror"
                                            placeholder="Enter city" required>
                                        @error('city')
                                            <div class="err">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="sec"><i class="fas fa-baseball-bat-ball"></i> Playing profile</div>
                                <label class="font-weight-bold required">Role</label>
                                <div class="tiles mb-1" id="g-role">
                                    @foreach ([['batsman', 'fa-baseball-bat-ball', 'Batsman'], ['bowler', 'fa-bullseye', 'Bowler'], ['wicket_keeper', 'fa-hand', 'Wicket Keeper'], ['all_rounder', 'fa-bolt', 'All-Rounder']] as [$v, $ic, $l])
                                        <label class="tile"><input type="radio" name="role"
                                                value="{{ $v }}"
                                                {{ old('role') === $v ? 'checked' : '' }}><span><i
                                                    class="fas {{ $ic }}"></i>{{ $l }}</span></label>
                                    @endforeach
                                </div>
                                @error('role')
                                    <div class="err">{{ $message }}</div>
                                @enderror

                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold required">Batting Style</label>
                                        <div class="tiles" id="g-batting_style">
                                            @foreach (['right_handed' => 'Right Handed', 'left_handed' => 'Left Handed'] as $v => $l)
                                                <label class="tile sm"><input type="radio" name="batting_style"
                                                        value="{{ $v }}"
                                                        {{ old('batting_style') === $v ? 'checked' : '' }}><span>{{ $l }}</span></label>
                                            @endforeach
                                        </div>
                                        @error('batting_style')
                                            <div class="err">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold required">Bowling Style</label>
                                        <div class="tiles" id="g-bowling_style">
                                            @foreach (['right' => 'Right Handed', 'left' => 'Left Handed', 'na' => 'N/A'] as $v => $l)
                                                <label class="tile sm"><input type="radio" name="bowling_style"
                                                        value="{{ $v }}"
                                                        {{ old('bowling_style') === $v ? 'checked' : '' }}><span>{{ $l }}</span></label>
                                            @endforeach
                                        </div>
                                        @error('bowling_style')
                                            <div class="err">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="sec"><i class="fas fa-file-shield"></i> Photo and documents</div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold required">Player Photo</label>
                                        <input name="photo" type="file" class="filepond"
                                            data-types="image/jpeg,image/png,image/webp"
                                            data-label="Drop your photo or <span class='filepond--label-action'>Browse</span>"
                                            required>
                                        <div class="hint">Clear face photo. JPG, PNG or WEBP, max 5 MB.</div>
                                        @error('photo')
                                            <div class="err">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold required">Original Proof (ID)</label>
                                        <input name="original_proof" type="file" class="filepond"
                                            data-types="image/jpeg,image/png,image/webp,application/pdf"
                                            data-label="Drop your ID or <span class='filepond--label-action'>Browse</span>"
                                            required>
                                        <div class="hint">Aadhaar, school or college ID. Image or PDF, max 5 MB.
                                        </div>
                                        @error('original_proof')
                                            <div class="err">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @unless ($tournament->is_pr_free)
                                    <div class="sec"><i class="fas fa-receipt"></i> Payment proof</div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold required">Payment Screenshot</label>
                                            <input name="payment_screenshot" type="file" class="filepond"
                                                data-types="image/jpeg,image/png,image/webp"
                                                data-label="Drop the screenshot or <span class='filepond--label-action'>Browse</span>"
                                                required>
                                            <div class="hint">Must show the successful payment. Max 5 MB.</div>
                                            @error('payment_screenshot')
                                                <div class="err">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">UTR / Transaction ID</label>
                                            <input type="text" name="payment_reference"
                                                value="{{ old('payment_reference') }}" maxlength="100"
                                                class="form-control form-control-lg"
                                                placeholder="Optional, speeds up verification">
                                        </div>
                                    </div>
                                @endunless

                                <div class="custom-control custom-checkbox mt-3">
                                    <input type="checkbox" class="custom-control-input" id="confirm"
                                        name="confirm" value="1" {{ old('confirm') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="confirm">I confirm my details and
                                        documents are correct. Wrong details can lead to rejection.</label>
                                </div>
                                @error('confirm')
                                    <div class="err">{{ $message }}</div>
                                @enderror

                                <div class="text-right mt-4 border-top pt-3">
                                    <button type="submit" id="submitBtn"
                                        class="btn btn-primary btn-lg px-5 shadow font-weight-bold"
                                        style="border-radius:8px">
                                        <i class="fas fa-check-circle mr-2"></i> Submit Registration
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Right (col-4) - Added pay-col class --}}
                <div class="col-lg-4 col-md-12 mb-4 pay-col">
                    <div class="card border-0 shadow-lg sticky-top pay">
                        <div class="card-body text-center p-4">
                            <h4 class="font-weight-bold mb-3"><i class="fas fa-wallet text-warning mr-2"></i>
                                Registration Fee</h4>

                            @if ($tournament->is_pr_free)
                                <div class="amt mb-2">Free</div>
                                <p class="text-light mb-0" style="opacity:.8">No payment needed for this tournament.
                                    Just fill in the form.</p>
                            @else
                                <div class="qr mb-3">
                                    {{-- Dynamic QR Code --}}
                                    @if ($tournament->payment_qr_code)
                                        <img src="{{ asset('storage/' . $tournament->payment_qr_code) }}"
                                            alt="Payment QR" style="width:200px;height:200px;object-fit:contain">
                                    @else
                                        <div class="d-flex flex-column align-items-center justify-content-center text-muted"
                                            style="width:200px;height:200px;background:#f8fafc;border:2px dashed #cbd5e1;border-radius:12px;">
                                            <i class="fas fa-qrcode fa-3x mb-2 text-slate-300"></i>
                                            <span style="font-size: 0.8rem;">QR Code Not Available</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="amt mb-1">₹
                                    {{ is_numeric($tournament->pr_amount) ? number_format($tournament->pr_amount) : $tournament->pr_amount }}
                                </div>
                                <p class="text-light mb-3" style="opacity:.75;font-size:.85rem">Scan to pay via GPay /
                                    PhonePe / Paytm</p>

                                <div class="text-left">
                                    <div class="row-d">
                                        <span>Pay to</span>
                                        <strong>{{ $tournament->organizer->name ?? 'Organizer' }}</strong>
                                    </div>

                                    @if ($tournament->upi_id)
                                        <div class="row-d">
                                            <span>UPI ID</span>
                                            <div class="upi-container">
                                                <strong id="upi"
                                                    title="{{ $tournament->upi_id }}">{{ $tournament->upi_id }}</strong>
                                                <button type="button" class="copy ml-2" id="copyUpi">Copy</button>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($tournament->contact_phone)
                                        <div class="row-d">
                                            <span>Contact</span>
                                            <strong>{{ $tournament->contact_phone }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="text-left mt-3">
                                    <h6 class="font-weight-bold mb-2"><i class="fas fa-info-circle mr-1"></i>
                                        Instructions</h6>
                                    <ol>
                                        <li>Pay the exact registration fee to the QR.</li>
                                        <li>Take a clear screenshot of the success screen.</li>
                                        <li>Upload it in the form.</li>
                                        <li>Your registration stays pending until the admin verifies the payment.</li>
                                    </ol>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FilePond: storeAsFile keeps normal multipart form posting
            FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize,
                FilePondPluginImagePreview);
            document.querySelectorAll('input.filepond').forEach(function(el) {
                FilePond.create(el, {
                    storeAsFile: true,
                    credits: false,
                    required: el.required,
                    maxFileSize: '5MB',
                    acceptedFileTypes: (el.dataset.types || '').split(','),
                    labelIdle: el.dataset.label ||
                        'Drop file or <span class="filepond--label-action">Browse</span>',
                    labelFileTypeNotAllowed: 'This file type is not allowed',
                    labelMaxFileSizeExceeded: 'File is larger than 5 MB',
                });
            });

            // phone: digits / + / space only
            var phone = document.getElementById('phone');
            if (phone) phone.addEventListener('input', function() {
                phone.value = phone.value.replace(/[^\d+\s]/g, '');
            });

            // client-side check so users don't lose files to a server round trip
            var form = document.getElementById('regForm');
            if (form) form.addEventListener('submit', function(e) {
                var missing = [];
                ['role', 'batting_style', 'bowling_style'].forEach(function(n) {
                    if (!form.querySelector('input[name="' + n + '"]:checked')) missing.push(n
                        .replace('_', ' '));
                });
                form.querySelectorAll('input.filepond').forEach(function(el) {
                    var pond = FilePond.find(el);
                    if (el.required && pond && pond.getFiles().length === 0) missing.push(el.name
                        .replace('_', ' '));
                });
                var box = document.getElementById('clientErr');
                if (missing.length) {
                    e.preventDefault();
                    box.textContent = 'Please complete: ' + missing.join(', ') + '.';
                    box.classList.remove('d-none');
                    box.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    return;
                }
                box.classList.add('d-none');
                var b = document.getElementById('submitBtn');
                b.disabled = true;
                b.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Submitting...';
            });

            // copy UPI
            var copy = document.getElementById('copyUpi');
            if (copy) copy.addEventListener('click', function() {
                var upiText = document.getElementById('upi').getAttribute('title') || document
                    .getElementById('upi').textContent.trim();

                navigator.clipboard.writeText(upiText).then(function() {
                    var originalText = copy.textContent;
                    copy.textContent = 'Copied!';
                    setTimeout(function() {
                        copy.textContent = originalText;
                    }, 1500);
                });
            });

            // registration countdown
            var c = document.querySelector('.closes[data-end]');
            if (c) {
                var end = new Date(c.dataset.end).getTime(),
                    out = document.getElementById('countdown');
                (function tick() {
                    var s = Math.floor((end - Date.now()) / 1000);
                    if (s <= 0) {
                        out.textContent = 'now';
                        return;
                    }
                    var d = Math.floor(s / 86400),
                        h = Math.floor(s % 86400 / 3600),
                        m = Math.floor(s % 3600 / 60);
                    out.textContent = (d ? d + 'd ' : '') + h + 'h ' + m + 'm ' + (s % 60) + 's';
                    setTimeout(tick, 1000);
                })();
            }
        });
    </script>
</body>

</html>