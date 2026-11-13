@extends('layouts.main')

@section('title')
    Teams Pool Spin - {{ $tournament->name }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">Teams Pool Spin</h1>
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
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('tournaments.auction', $tournament->id) }}" class="text-dark"><i
                                    class="nav-icon fas fa-gavel mr-1"></i>{{ __('auction') }}</a>
                        </li>
                        <li class="breadcrumb-item active brand-red">
                            <i class="nav-icon fas fa-shield-alt mr-1"></i>Teams Spin
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- Left Column: Team reel + pool buckets -->
                <div class="col-lg-7 col-md-12 mb-4">
                    <div class="card shadow-sm border-0" style="border-radius: 16px;">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                            <h5 class="font-weight-bold text-dark mb-0">Spin to Assign Pool</h5>
                            <p class="text-muted text-sm mt-1">Spin to pick a team. Then click assign to drop them into the
                                next pool.</p>
                        </div>
                        <div class="card-body text-center d-flex flex-column align-items-center justify-content-center"
                            style="min-height: 450px;">

                            @if ($availableTeams->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                                    <h4 class="font-weight-bold">All Teams Assigned!</h4>
                                    <p class="text-muted">All teams have been successfully placed into pools.</p>
                                    <a href="{{ route('tournaments.auction', $tournament->id) }}"
                                        class="btn btn-primary mt-3">Back to Auction</a>
                                </div>
                            @else
                                <!-- Hidden Form for Submission -->
                                <form action="{{ route('auction.assign-team-pool', $tournament->id) }}" method="POST"
                                    id="assignForm" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="team_id" id="hiddenTeamId">
                                </form>

                                <div class="stage" id="stage">

                                    <!-- Team reel machine -->
                                    <div class="machine" id="machine">
                                        <div class="bulbs">
                                            @for ($i = 0; $i < 14; $i++)
                                                <i></i>
                                            @endfor
                                        </div>
                                        <div class="machine-title">
                                            <span class="mini-ball"></span> TEAM DRAW <span class="mini-ball"></span>
                                        </div>

                                        <div class="team-window" id="teamWindow">
                                            <div class="team-strip" id="teamStrip"></div>
                                            <div class="ptr ptr-l"></div>
                                            <div class="ptr ptr-r"></div>
                                        </div>

                                        <div class="bulbs mt-3">
                                            @for ($i = 0; $i < 14; $i++)
                                                <i></i>
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="action-area mt-4 d-flex flex-column align-items-center">
                                        <!-- Spin Button -->
                                        <button class="btn btn-brand-red btn-lg px-5 py-3 font-weight-bold shadow-lg"
                                            id="spinBtn"
                                            style="border-radius: 30px; font-size: 20px; letter-spacing: 2px; min-width: 220px;">
                                            <i class="fas fa-play mr-2"></i> SPIN
                                        </button>

                                        <!-- Assign Button (Hidden initially) -->
                                        <button type="button"
                                            class="btn btn-success btn-lg px-5 py-3 font-weight-bold shadow-lg mt-3"
                                            id="assignBtn"
                                            style="border-radius: 30px; font-size: 20px; letter-spacing: 2px; min-width: 220px; display: none;">
                                            <i class="fas fa-check-circle mr-2"></i> ASSIGN TO POOL
                                        </button>
                                    </div>

                                    <!-- Next pool & Buckets -->
                                    <div class="pool-section mt-4">
                                        <div class="next-pill mb-3">
                                            NEXT POOL <span class="next-letter" id="nextPoolLabel">-</span>
                                        </div>
                                        <div class="pool-row" id="poolRow"></div>
                                    </div>

                                    <!-- Ball that flies into the pool -->
                                    <div class="fly-ball" id="flyBall"><span id="flyInitials"></span></div>
                                </div>

                                <!-- Status Message -->
                                <div id="statusMessage" class="mt-3 font-weight-bold"
                                    style="font-size: 1.15rem; display: none;"></div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12">
                    <div class="card shadow-sm border-0" style="border-radius: 16px;">
                        <div
                            class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bold mb-0 text-dark">
                                <i class="fas fa-layer-group brand-red mr-2"></i> Pools Overview
                            </h5>
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <span class="badge badge-dark px-3 py-2">{{ $tournament->total_pools }} Pools</span>

                                <!-- Download Button -->
                                <button type="button" class="btn btn-sm btn-outline-dark font-weight-bold"
                                    id="downloadPosterBtn">
                                    <i class="fas fa-image"></i> Download Poster
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <!-- YOUR EXACT TABLE CODE GOES HERE (No changes) -->
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pools-table">
                                    @foreach ($pools as $pool)
                                        <tr id="pool-row-{{ $pool }}">
                                            <td class="align-middle pl-4">
                                                <span class="badge badge-dark px-3 py-2" style="font-size: 1rem;">Pool
                                                    {{ $pool }}</span>
                                            </td>
                                            <td class="align-middle" id="pool-teams-{{ $pool }}">
                                                @if (isset($assignedTeams[$pool]))
                                                    @foreach ($assignedTeams[$pool] as $t)
                                                        <span
                                                            class="badge badge-light border text-dark mb-1 px-2 py-1">{{ $t->name }}</span><br>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted font-italic text-sm">No teams yet</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- HIDDEN POSTER TEMPLATE FOR DOWNLOAD -->
    <div id="poster-template"
        style="position: absolute; left: -9999px; top: 0; width: 900px; background: linear-gradient(135deg, #0b0f19 0%, #1a2235 100%); font-family: 'Inter', sans-serif; padding: 50px; box-sizing: border-box; overflow: hidden;">

        <!-- Abstract Background Elements -->
        <svg style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;"
            viewBox="0 0 900 1000">
            <!-- Top Right Slashes -->
            {{-- <polygon points="900,0 750,0 900,150" fill="#fbbf24" />
            <polygon points="900,100 820,0 900,0" fill="#be212a" />
            <!-- Bottom Left Slashes -->
            <polygon points="0,1000 150,1000 0,850" fill="#be212a" /> --}}
            <!-- Center Glow -->
            <circle cx="450" cy="500" r="400" fill="rgba(190, 33, 42, 0.05)" />
        </svg>

        <div style="position: relative; z-index: 2;">

            <!-- Header Section -->
            <div
                style="display: flex; align-items: center; justify-content: center; gap: 30px; margin-bottom: 50px; text-align: center;">
                @if ($tournament->logo)
                    <img src="{{ asset('storage/' . $tournament->logo) }}" alt="Logo"
                        style="width: 120px; height: 120px; object-fit: contain; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.5));">
                @else
                    <div
                        style="width: 120px; height: 120px; background: #1e293b; border-radius: 20px; display: flex; align-items: center; justify-content: center; border: 2px solid #be212a;">
                        <i class="fas fa-trophy" style="font-size: 50px; color: #fbbf24;"></i>
                    </div>
                @endif

                <div style="text-align: left;">
                    <h2
                        style="color: #ffffff; font-weight: 900; font-size: 42px; margin: 0; letter-spacing: -1px; line-height: 1.1; text-transform: uppercase;">
                        {{ $tournament->name }}
                    </h2>
                    <p
                        style="color: #fbbf24; font-weight: 800; font-size: 16px; margin: 10px 0 5px 0; letter-spacing: 3px;">
                        {{ $tournament->short_code }} &bull; POOL DETAILS
                    </p>
                    <p style="color: #94a3b8; font-size: 15px; margin: 0;">
                        <i class="fas fa-map-marker-alt" style="color: #be212a; margin-right: 5px;"></i>
                        {{ $tournament->venue }}{{ $tournament->city ? ', ' . $tournament->city : '' }}
                    </p>
                </div>
            </div>

            <!-- Pools Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">

                @foreach ($pools as $pool)
                    <div
                        style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); position: relative; overflow: hidden;">

                        <!-- Red Glow in Pool Card -->
                        <div
                            style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(190,33,42,0.15) 0%, rgba(190,33,42,0) 70%); border-radius: 50%;">
                        </div>

                        <!-- Pool Header -->
                        <div
                            style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
                            <h3 style="color: #ffffff; font-weight: 900; font-size: 24px; margin: 0; letter-spacing: 1px;">
                                POOL {{ $pool }}
                            </h3>
                            <span
                                style="background: #be212a; color: #ffffff; font-weight: 800; font-size: 12px; padding: 4px 12px; border-radius: 20px;">
                                {{ isset($assignedTeams[$pool]) ? count($assignedTeams[$pool]) : 0 }} TEAMS
                            </span>
                        </div>

                        <!-- Teams List -->
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            @if (isset($assignedTeams[$pool]) && count($assignedTeams[$pool]) > 0)
                                @foreach ($assignedTeams[$pool] as $index => $t)
                                    <div
                                        style="display: flex; align-items: center; background: rgba(255,255,255,0.05); border-radius: 8px; padding: 12px 15px; border-left: 4px solid #fbbf24;">

                                        <!-- Team Number -->
                                        <span
                                            style="color: rgba(255,255,255,0.4); font-weight: 800; font-size: 14px; margin-right: 15px; width: 20px;">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </span>

                                        <!-- Logo -->
                                        <div
                                            style="width: 32px; height: 32px; background: #1e293b; border-radius: 50%; margin-right: 15px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid rgba(255,255,255,0.2);">
                                            @if ($t->logo)
                                                <img src="{{ asset('storage/' . $t->logo) }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <i class="fas fa-shield-alt" style="color: #64748b; font-size: 14px;"></i>
                                            @endif
                                        </div>

                                        <!-- Name -->
                                        <span
                                            style="color: #ffffff; font-weight: 700; font-size: 16px; text-transform: uppercase; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1;">
                                            {{ $t->name }}
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <div style="text-align: center; padding: 20px 0;">
                                    <i class="fas fa-hourglass-half"
                                        style="color: #475569; font-size: 24px; margin-bottom: 10px;"></i>
                                    <p style="color: #64748b; font-size: 14px; margin: 0; font-weight: 600;">Awaiting
                                        Teams...</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Footer -->
            <div
                style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
                <p style="color: #475569; font-size: 13px; font-weight: 800; letter-spacing: 2px; margin: 0;">
                    <i class="fas fa-bolt" style="color: #fbbf24; margin-right: 5px;"></i> POWERED BY AUCTIONHUB
                </p>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        :root {
            --brand-primary: #000000;
            --brand-secondary: #be212a;
        }

        .brand-red {
            color: var(--brand-secondary) !important;
        }

        .btn-brand-red {
            background: var(--brand-secondary);
            color: #fff;
            border: none;
            transition: background .2s ease, transform .2s ease;
        }

        .btn-brand-red:hover:not(:disabled) {
            background: #9a1a22;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-brand-red:disabled {
            opacity: .75;
        }

        /* ---------- Stage ---------- */
        .stage {
            position: relative;
            width: 100%;
            max-width: 460px;
            margin: 0 auto;
            --cell: 58px;
        }

        /* ---------- Machine ---------- */
        .machine {
            background: linear-gradient(160deg, #161616, #000);
            border: 4px solid var(--brand-secondary);
            border-radius: 16px;
            padding: 14px 16px 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .4), inset 0 0 40px rgba(0, 0, 0, .8);
        }

        .bulbs {
            display: flex;
            justify-content: space-between;
            padding: 0 2px;
        }

        .bulbs i {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #4b1519;
        }

        .machine.spinning .bulbs i {
            animation: bulb .45s infinite alternate;
        }

        .machine.spinning .bulbs i:nth-child(odd) {
            animation-delay: .22s;
        }

        .machine.done .bulbs i {
            background: #34d399;
            box-shadow: 0 0 8px #34d399;
        }

        .machine-title {
            color: #fbbf24;
            font-weight: 800;
            font-size: .8rem;
            letter-spacing: 4px;
            margin: 12px 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .mini-ball {
            width: 11px;
            height: 11px;
            border-radius: 50%;
            display: inline-block;
            background: radial-gradient(circle at 32% 28%, #ef4b55, #be212a 60%, #7f1219);
        }

        /* ---------- Team reel ---------- */
        .team-window {
            position: relative;
            height: calc(var(--cell) * 3);
            overflow: hidden;
            background: #050505;
            border: 2px solid #2a2a2a;
            border-radius: 10px;
            box-shadow: inset 0 0 18px rgba(0, 0, 0, .9);
        }

        .team-window::before {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            top: var(--cell);
            height: var(--cell);
            border-top: 2px solid rgba(190, 33, 42, .85);
            border-bottom: 2px solid rgba(190, 33, 42, .85);
            background: rgba(190, 33, 42, .12);
            z-index: 1;
            pointer-events: none;
        }

        .team-window::after {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            background: linear-gradient(to bottom, rgba(0, 0, 0, .8), transparent 34%, transparent 66%, rgba(0, 0, 0, .8));
        }

        .team-strip {
            will-change: transform;
        }

        .team-cell {
            height: var(--cell);
            /* display: flex; */
            align-items: center;
            justify-content: center;
            padding: 0 40px;
            /* Increased padding so text doesn't overlap arrows */
            font-weight: 800;
            font-size: 1.3rem;
            letter-spacing: 1px;
            color: #fbbf24;
            text-shadow: 0 0 12px rgba(251, 191, 36, .6);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: uppercase;
            width: 100%;
            text-align: center;
            /* Explicitly center text */
        }

        .machine.done .team-cell.picked {
            color: #34d399;
            text-shadow: 0 0 16px rgba(52, 211, 153, .8);
        }

        .ptr {
            position: absolute;
            top: var(--cell);
            height: var(--cell);
            width: 0;
            z-index: 3;
            display: flex;
            align-items: center;
        }

        .ptr::after {
            content: '';
            border: 9px solid transparent;
        }

        .ptr-l {
            left: 6px;
        }

        .ptr-l::after {
            border-left: 13px solid var(--brand-secondary);
            border-right: 0;
        }

        .ptr-r {
            right: 6px;
        }

        .ptr-r::after {
            border-right: 13px solid var(--brand-secondary);
            border-left: 0;
        }

        /* ---------- Next pool + buckets ---------- */
        .pool-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .next-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: 3px;
            color: #6b7280;
        }

        .next-letter {
            background: var(--brand-primary);
            color: #fff;
            font-size: 1.15rem;
            letter-spacing: 0;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--brand-secondary);
        }

        .pool-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 4px;
        }

        .pool-tile {
            width: 86px;
            padding: 10px 6px 8px;
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            background: #f8fafc;
            transition: background .3s, border-color .3s, color .3s;
        }

        .pool-tile .letter {
            font-size: 1.9rem;
            font-weight: 900;
            line-height: 1;
            color: var(--brand-primary);
        }

        .pool-tile .cnt {
            font-size: .7rem;
            font-weight: 700;
            color: #6b7280;
            margin-top: 4px;
        }

        .pool-tile .dots {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 3px;
            min-height: 8px;
            margin-top: 5px;
        }

        .pool-tile .dots i {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--brand-secondary);
        }

        .pool-tile.next {
            border: 2px solid var(--brand-secondary);
            background: #fdf2f3;
            animation: nextPulse 1.4s infinite;
        }

        .pool-tile.got {
            background: var(--brand-primary);
            border: 2px solid var(--brand-primary);
            animation: none;
        }

        .pool-tile.got .letter {
            color: #fff;
        }

        .pool-tile.got .cnt {
            color: #d1d5db;
        }

        .plus-one {
            position: absolute;
            font-weight: 900;
            color: var(--brand-secondary);
            font-size: 1.2rem;
            pointer-events: none;
            z-index: 21;
        }

        /* ---------- Flying ball ---------- */
        .fly-ball {
            position: absolute;
            left: 0;
            top: 0;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 32% 28%, #ef4b55, #be212a 55%, #7f1219);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .5);
            color: #fff;
            font-weight: 900;
            font-size: 1.05rem;
            letter-spacing: 1px;
            opacity: 0;
            z-index: 20;
            pointer-events: none;
            will-change: transform;
        }

        .fly-ball::before {
            content: '';
            position: absolute;
            inset: 7%;
            border-radius: 50%;
            border: 2px dashed rgba(255, 255, 255, .55);
        }

        .fly-ball span {
            position: relative;
            text-shadow: 0 1px 3px rgba(0, 0, 0, .6);
        }

        .fly-ball.spin::before {
            animation: seamSpin .3s linear infinite;
        }

        #statusMessage {
            color: var(--brand-primary);
        }

        @keyframes bulb {
            from {
                background: #4b1519;
                box-shadow: none;
            }

            to {
                background: #fbbf24;
                box-shadow: 0 0 10px #fbbf24;
            }
        }

        @keyframes nextPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(190, 33, 42, .45);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(190, 33, 42, 0);
            }
        }

        @keyframes seamSpin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        const availableTeams = Object.values(@json($availableTeams));
        const pools = Object.values(@json($pools));
        const assigned = @json($assignedTeams);

        const stage = document.getElementById('stage');
        const machine = document.getElementById('machine');
        const teamWindow = document.getElementById('teamWindow');
        const teamStrip = document.getElementById('teamStrip');
        const poolRow = document.getElementById('poolRow');
        const nextLabel = document.getElementById('nextPoolLabel');
        const flyBall = document.getElementById('flyBall');
        const flyInitials = document.getElementById('flyInitials');
        const spinBtn = document.getElementById('spinBtn');
        const assignBtn = document.getElementById('assignBtn');
        const statusMsg = document.getElementById('statusMessage');

        let currentTeam = null;
        let currentPool = null;

        if (availableTeams.length && spinBtn) init();

        function init() {
            // ---------- Pool state (orderly: fewest teams first, then A, B, C...) ----------
            const counts = {};
            pools.forEach(p => {
                counts[p] = assigned && assigned[p] ? Object.keys(assigned[p]).length : 0;
            });

            function getNextPool() {
                let best = pools[0];
                pools.forEach(p => {
                    if (counts[p] < counts[best]) best = p;
                });
                return best;
            }

            function buildTiles() {
                poolRow.innerHTML = '';
                pools.forEach(p => {
                    const tile = document.createElement('div');
                    tile.className = 'pool-tile';
                    tile.dataset.pool = p;
                    tile.innerHTML =
                        `<div class="letter">${p}</div><div class="cnt"></div><div class="dots"></div>`;
                    poolRow.appendChild(tile);
                });
                refreshTiles();
            }

            function refreshTiles() {
                const np = getNextPool();
                nextLabel.textContent = np;
                poolRow.querySelectorAll('.pool-tile').forEach(tile => {
                    const p = tile.dataset.pool;
                    tile.classList.toggle('next', p === np);
                    tile.querySelector('.cnt').textContent = counts[p] + (counts[p] === 1 ? ' team' : ' teams');
                    tile.querySelector('.dots').innerHTML = '<i></i>'.repeat(Math.min(counts[p], 12));
                });
            }

            // ---------- Team reel ----------
            const C = availableTeams.length;
            const REPS = Math.max(3, Math.ceil(60 / C));
            let html = '';
            for (let r = 0; r < REPS; r++) {
                availableTeams.forEach((t, i) => {
                    html += `<div class="team-cell" data-i="${i}" data-r="${r}"></div>`;
                });
            }
            teamStrip.innerHTML = html;
            const cells = teamStrip.querySelectorAll('.team-cell');
            cells.forEach(c => {
                c.textContent = availableTeams[+c.dataset.i].name;
            });

            // Calculate exact height of a cell
            const cellH = () => teamWindow.clientHeight / 3;
            let cur = 0;

            // Math to perfectly center the item:
            // We start at (C + cur - 1) to put the first item exactly in the middle slot
            const place = () => {
                const offset = (C + cur - 1) * cellH();
                teamStrip.style.transform = `translateY(-${offset}px)`;
            };
            place();
            window.addEventListener('resize', place);

            buildTiles();

            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            let isSpinning = false;

            spinBtn.addEventListener('click', async function() {
                if (isSpinning) return;
                isSpinning = true;
                spinBtn.disabled = true;
                spinBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> SPINNING...';

                assignBtn.style.display = 'none';
                statusMsg.style.display = 'none';
                machine.classList.remove('done');

                // Pick the team (random) and its pool (strictly in order)
                const t = Math.floor(Math.random() * C);
                currentTeam = availableTeams[t];
                currentPool = getNextPool();

                if (!reduceMotion) {
                    // 1) Reel spins and slows onto the team
                    machine.classList.add('spinning');
                    const h = cellH();
                    const anim = teamStrip.animate([{
                            transform: `translateY(${-(C + cur - 1) * h}px)`
                        },
                        {
                            transform: `translateY(${-((REPS - 1) * C + t - 1) * h}px)`
                        }
                    ], {
                        duration: 3200,
                        easing: 'cubic-bezier(.12,.6,.15,1)',
                        fill: 'forwards'
                    });
                    await anim.finished;
                    cur = t;
                    place();
                    anim.cancel();
                    machine.classList.remove('spinning');
                    machine.classList.add('done');
                    cells.forEach(c => c.classList.toggle('picked', +c.dataset.i === t && +c.dataset.r === 1));

                    // Wait a moment before showing the assign button
                    await wait(400);
                }

                // Show Assign Button
                isSpinning = false;
                spinBtn.disabled = false;
                spinBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i> SPIN AGAIN';
                assignBtn.style.display = 'inline-block';
                assignBtn.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ASSIGN TO POOL ${currentPool}`;
            });

            // Handle Assign Button Click
            assignBtn.addEventListener('click', async function() {
                if (!currentTeam || !currentPool) return;

                assignBtn.disabled = true;
                assignBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> ASSIGNING...';

                if (!reduceMotion) {
                    // 2) A ball with the team's initials flies into the pool bucket
                    await dropBall(currentTeam, currentPool);
                }

                // 3) Update UI, then submit form
                counts[currentPool]++;
                const tile = poolRow.querySelector(`[data-pool="${currentPool}"]`);
                tile.classList.remove('next');
                tile.classList.add('got');
                refreshTiles();
                tile.classList.add('got');
                tile.classList.remove('next');
                addToTable(currentPool, currentTeam);

                statusMsg.innerHTML =
                    `<i class="fas fa-check-circle mr-2"></i> <span class="brand-red">${escapeHtml(currentTeam.name)}</span> assigned to Pool ${currentPool}! Saving...`;
                statusMsg.style.display = 'block';

                document.getElementById('hiddenTeamId').value = currentTeam.id;
                setTimeout(() => document.getElementById('assignForm').submit(), 1000);
            });

            async function dropBall(team, pool) {
                const tile = poolRow.querySelector(`[data-pool="${pool}"]`);
                const sr = stage.getBoundingClientRect();
                const rr = teamWindow.getBoundingClientRect();
                const tr = tile.getBoundingClientRect();
                const half = 28;
                const x0 = rr.left - sr.left + rr.width / 2,
                    y0 = rr.top - sr.top + rr.height / 2;
                const x1 = tr.left - sr.left + tr.width / 2,
                    y1 = tr.top - sr.top + tr.height / 2;
                const apexY = Math.min(y0, y1) - 40;

                flyInitials.textContent = initialsOf(team.name);
                flyBall.classList.add('spin');
                const a = flyBall.animate([{
                        transform: `translate(${x0 - half}px, ${y0 - half}px) scale(.5)`,
                        opacity: 0,
                        offset: 0,
                        easing: 'ease-out'
                    },
                    {
                        transform: `translate(${x0 - half}px, ${y0 - half}px) scale(1.1)`,
                        opacity: 1,
                        offset: 0.12,
                        easing: 'ease-out'
                    },
                    {
                        transform: `translate(${(x0 + x1) / 2 - half}px, ${apexY - half}px) scale(1.2)`,
                        opacity: 1,
                        offset: 0.55,
                        easing: 'ease-in'
                    },
                    {
                        transform: `translate(${x1 - half}px, ${y1 - half}px) scale(.55)`,
                        opacity: 1,
                        offset: 1
                    }
                ], {
                    duration: 1100,
                    fill: 'forwards'
                });
                await a.finished;
                a.cancel();
                flyBall.classList.remove('spin');
                flyBall.style.opacity = 0;

                // Landing effects
                tile.animate([{
                    transform: 'scale(1)'
                }, {
                    transform: 'scale(1.18)'
                }, {
                    transform: 'scale(.96)'
                }, {
                    transform: 'scale(1)'
                }], {
                    duration: 420,
                    easing: 'ease-out'
                });

                const plus = document.createElement('div');
                plus.className = 'plus-one';
                plus.textContent = '+1';
                plus.style.left = (x1 - 10) + 'px';
                plus.style.top = (y1 - 50) + 'px';
                stage.appendChild(plus);
                plus.animate([{
                        transform: 'translateY(0)',
                        opacity: 1
                    },
                    {
                        transform: 'translateY(-34px)',
                        opacity: 0
                    }
                ], {
                    duration: 800,
                    easing: 'ease-out'
                }).finished.then(() => plus.remove());

                await wait(300);
            }

            function addToTable(pool, team) {
                const cell = document.getElementById('pool-teams-' + pool);
                const row = document.getElementById('pool-row-' + pool);
                if (cell) {
                    const empty = cell.querySelector('.font-italic');
                    if (empty) empty.remove();
                    cell.insertAdjacentHTML('beforeend',
                        `<span class="badge badge-light border text-dark mb-1 px-2 py-1">${escapeHtml(team.name)}</span><br>`
                    );
                }
                if (row) {
                    row.animate([{
                            backgroundColor: '#fde8ea'
                        },
                        {
                            backgroundColor: '#fde8ea',
                            offset: 0.7
                        },
                        {
                            backgroundColor: 'transparent'
                        }
                    ], {
                        duration: 1500
                    });
                }
            }
        }

        function initialsOf(name) {
            const w = name.trim().split(/\s+/);
            return (w.length > 1 ? w[0][0] + w[1][0] : name.slice(0, 2)).toUpperCase();
        }

        function wait(ms) {
            return new Promise(r => setTimeout(r, ms));
        }

        function escapeHtml(s) {
            return String(s).replace(/[&<>"']/g, c => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [c]));
        }

        document.getElementById('downloadImageBtn')?.addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            btn.disabled = true;

            // Grab the card element
            const cardElement = document.getElementById('pool-card');

            // html2canvas options for higher quality
            html2canvas(cardElement, {
                scale: 2, // 2x scale for retina displays
                backgroundColor: '#ffffff', // Ensure background is white
                useCORS: true, // Allow loading external images (like logos) if present
                scrollY: -window.scrollY // Fix any scrolling offsets
            }).then(canvas => {
                // Convert canvas to data URL
                const image = canvas.toDataURL("image/png");

                // Create a temporary link to download
                const link = document.createElement('a');
                link.download = '{{ $tournament->short_code }}_Pools_' + new Date().toISOString().slice(0,
                    10) + '.png';
                link.href = image;
                link.click();

                // Restore button
                btn.innerHTML = originalText;
                btn.disabled = false;
            }).catch(err => {
                console.error("Error generating image:", err);
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert("Failed to generate image. Please try again.");
            });
        });
    </script>

@section('script')
    <!-- Include html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        // ==========================================
        // 1. TEAM SPIN LOGIC
        // ==========================================
        const availableTeams = Object.values(@json($availableTeams));
        const pools = Object.values(@json($pools));
        const assigned = @json($assignedTeams);

        const stage = document.getElementById('stage');
        const machine = document.getElementById('machine');
        const teamWindow = document.getElementById('teamWindow');
        const teamStrip = document.getElementById('teamStrip');
        const poolRow = document.getElementById('poolRow');
        const nextLabel = document.getElementById('nextPoolLabel');
        const flyBall = document.getElementById('flyBall');
        const flyInitials = document.getElementById('flyInitials');
        const spinBtn = document.getElementById('spinBtn');
        const assignBtn = document.getElementById('assignBtn');
        const statusMsg = document.getElementById('statusMessage');

        let currentTeam = null;
        let currentPool = null;

        if (availableTeams.length && spinBtn) init();

        function init() {
            const counts = {};
            pools.forEach(p => {
                counts[p] = assigned && assigned[p] ? Object.keys(assigned[p]).length : 0;
            });

            function getNextPool() {
                let best = pools[0];
                pools.forEach(p => {
                    if (counts[p] < counts[best]) best = p;
                });
                return best;
            }

            function buildTiles() {
                poolRow.innerHTML = '';
                pools.forEach(p => {
                    const tile = document.createElement('div');
                    tile.className = 'pool-tile';
                    tile.dataset.pool = p;
                    tile.innerHTML =
                    `<div class="letter">${p}</div><div class="cnt"></div><div class="dots"></div>`;
                    poolRow.appendChild(tile);
                });
                refreshTiles();
            }

            function refreshTiles() {
                const np = getNextPool();
                nextLabel.textContent = np;
                poolRow.querySelectorAll('.pool-tile').forEach(tile => {
                    const p = tile.dataset.pool;
                    tile.classList.toggle('next', p === np);
                    tile.querySelector('.cnt').textContent = counts[p] + (counts[p] === 1 ? ' team' : ' teams');
                    tile.querySelector('.dots').innerHTML = '<i></i>'.repeat(Math.min(counts[p], 12));
                });
            }

            const C = availableTeams.length;
            const REPS = Math.max(3, Math.ceil(60 / C));
            let html = '';
            for (let r = 0; r < REPS; r++) {
                availableTeams.forEach((t, i) => {
                    html += `<div class="team-cell" data-i="${i}" data-r="${r}"></div>`;
                });
            }
            teamStrip.innerHTML = html;
            const cells = teamStrip.querySelectorAll('.team-cell');
            cells.forEach(c => {
                c.textContent = availableTeams[+c.dataset.i].name;
            });

            const cellH = () => teamWindow.clientHeight / 3;
            let cur = 0;
            const place = () => {
                const offset = (C + cur - 1) * cellH();
                teamStrip.style.transform = `translateY(-${offset}px)`;
            };
            place();
            window.addEventListener('resize', place);
            buildTiles();

            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            let isSpinning = false;

            spinBtn.addEventListener('click', async function() {
                if (isSpinning) return;
                isSpinning = true;
                spinBtn.disabled = true;
                spinBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> SPINNING...';
                assignBtn.style.display = 'none';
                statusMsg.style.display = 'none';
                machine.classList.remove('done');

                const t = Math.floor(Math.random() * C);
                currentTeam = availableTeams[t];
                currentPool = getNextPool();

                if (!reduceMotion) {
                    machine.classList.add('spinning');
                    const h = cellH();
                    const anim = teamStrip.animate([{
                            transform: `translateY(${-(C + cur - 1) * h}px)`
                        },
                        {
                            transform: `translateY(${-((REPS - 1) * C + t - 1) * h}px)`
                        }
                    ], {
                        duration: 3200,
                        easing: 'cubic-bezier(.12,.6,.15,1)',
                        fill: 'forwards'
                    });

                    await anim.finished;
                    cur = t;
                    place();
                    anim.cancel();
                    machine.classList.remove('spinning');
                    machine.classList.add('done');
                    cells.forEach(c => c.classList.toggle('picked', +c.dataset.i === t && +c.dataset.r === 1));
                    await wait(400);
                }

                isSpinning = false;
                spinBtn.disabled = false;
                spinBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i> SPIN AGAIN';
                assignBtn.style.display = 'inline-block';
                assignBtn.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ASSIGN TO POOL ${currentPool}`;
            });

            assignBtn.addEventListener('click', async function() {
                if (!currentTeam || !currentPool) return;
                assignBtn.disabled = true;
                assignBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> ASSIGNING...';

                if (!reduceMotion) {
                    await dropBall(currentTeam, currentPool);
                }

                counts[currentPool]++;
                const tile = poolRow.querySelector(`[data-pool="${currentPool}"]`);
                tile.classList.remove('next');
                tile.classList.add('got');
                refreshTiles();
                addToTable(currentPool, currentTeam);

                statusMsg.innerHTML =
                    `<i class="fas fa-check-circle mr-2"></i> <span class="brand-red">${escapeHtml(currentTeam.name)}</span> assigned to Pool ${currentPool}! Saving...`;
                statusMsg.style.display = 'block';

                document.getElementById('hiddenTeamId').value = currentTeam.id;
                setTimeout(() => document.getElementById('assignForm').submit(), 1000);
            });

            async function dropBall(team, pool) {
                const tile = poolRow.querySelector(`[data-pool="${pool}"]`);
                const sr = stage.getBoundingClientRect();
                const rr = teamWindow.getBoundingClientRect();
                const tr = tile.getBoundingClientRect();
                const half = 28;
                const x0 = rr.left - sr.left + rr.width / 2,
                    y0 = rr.top - sr.top + rr.height / 2;
                const x1 = tr.left - sr.left + tr.width / 2,
                    y1 = tr.top - sr.top + tr.height / 2;
                const apexY = Math.min(y0, y1) - 40;

                flyInitials.textContent = initialsOf(team.name);
                flyBall.classList.add('spin');
                const a = flyBall.animate([{
                        transform: `translate(${x0 - half}px, ${y0 - half}px) scale(.5)`,
                        opacity: 0,
                        offset: 0,
                        easing: 'ease-out'
                    },
                    {
                        transform: `translate(${x0 - half}px, ${y0 - half}px) scale(1.1)`,
                        opacity: 1,
                        offset: 0.12,
                        easing: 'ease-out'
                    },
                    {
                        transform: `translate(${(x0 + x1) / 2 - half}px, ${apexY - half}px) scale(1.2)`,
                        opacity: 1,
                        offset: 0.55,
                        easing: 'ease-in'
                    },
                    {
                        transform: `translate(${x1 - half}px, ${y1 - half}px) scale(.55)`,
                        opacity: 1,
                        offset: 1
                    }
                ], {
                    duration: 1100,
                    fill: 'forwards'
                });
                await a.finished;
                a.cancel();
                flyBall.classList.remove('spin');
                flyBall.style.opacity = 0;

                tile.animate([{
                    transform: 'scale(1)'
                }, {
                    transform: 'scale(1.18)'
                }, {
                    transform: 'scale(.96)'
                }, {
                    transform: 'scale(1)'
                }], {
                    duration: 420,
                    easing: 'ease-out'
                });

                const plus = document.createElement('div');
                plus.className = 'plus-one';
                plus.textContent = '+1';
                plus.style.left = (x1 - 10) + 'px';
                plus.style.top = (y1 - 50) + 'px';
                stage.appendChild(plus);
                plus.animate([{
                    transform: 'translateY(0)',
                    opacity: 1
                }, {
                    transform: 'translateY(-34px)',
                    opacity: 0
                }], {
                    duration: 800,
                    easing: 'ease-out'
                }).finished.then(() => plus.remove());

                await wait(300);
            }

            function addToTable(pool, team) {
                const cell = document.getElementById('pool-teams-' + pool);
                const row = document.getElementById('pool-row-' + pool);
                if (cell) {
                    const empty = cell.querySelector('.font-italic');
                    if (empty) empty.remove();
                    cell.insertAdjacentHTML('beforeend',
                        `<span class="badge badge-light border text-dark mb-1 px-2 py-1">${escapeHtml(team.name)}</span><br>`
                        );
                }
                if (row) {
                    row.animate([{
                        backgroundColor: '#fde8ea'
                    }, {
                        backgroundColor: '#fde8ea',
                        offset: 0.7
                    }, {
                        backgroundColor: 'transparent'
                    }], {
                        duration: 1500
                    });
                }
            }
        }

        function initialsOf(name) {
            const w = name.trim().split(/\s+/);
            return (w.length > 1 ? w[0][0] + w[1][0] : name.slice(0, 2)).toUpperCase();
        }

        function wait(ms) {
            return new Promise(r => setTimeout(r, ms));
        }

        function escapeHtml(s) {
            return String(s).replace(/[&<>"']/g, c => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [c]));
        }

        // ==========================================
        // 2. DOWNLOAD POSTER LOGIC
        // ==========================================
        document.getElementById('downloadPosterBtn')?.addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
            btn.disabled = true;

            const posterElement = document.getElementById('poster-template');

            html2canvas(posterElement, {
                scale: 2,
                backgroundColor: '#0b0f19',
                useCORS: true,
            }).then(canvas => {
                const image = canvas.toDataURL("image/png");
                const link = document.createElement('a');
                link.download = '{{ $tournament->short_code }}_Pool_Details_' + new Date().toISOString()
                    .slice(0, 10) + '.png';
                link.href = image;
                link.click();

                btn.innerHTML = originalText;
                btn.disabled = false;
            }).catch(err => {
                console.error("Error generating poster:", err);
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert("Failed to generate poster. Please try again.");
            });
        });
    </script>
@endsection
@endsection
