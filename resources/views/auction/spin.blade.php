@extends('layouts.main')

@section('title')
    Spin Box - {{ $tournament->name }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">
                        {{ isset($spinType) && $spinType === 'unsold' ? 'Unsold Players Spin' : 'Auction Spin' }}
                    </h1>
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
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ isset($spinType) && $spinType === 'unsold' ? route('auction.spin-unsold', $tournament->id) : route('auction.spin', $tournament->id) }}"
                                class="text-dark">
                                <i class="nav-icon fas fa-sync-alt mr-1"></i>Spin
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center mt-4">

                    @if ($pendingPlayers->isEmpty())
                        <div class="card shadow-sm border-0 py-5">
                            <div class="card-body">
                                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                                <h3 class="font-weight-bold">All Players Spin!</h3>
                                <p class="text-muted">
                                    {{ isset($spinType) && $spinType === 'unsold' ? 'There are no unsold players left in the pool.' : 'There are no pending players left in the auction pool.' }}
                                </p>
                                <a href="{{ route('tournaments.auction', $tournament->id) }}"
                                    class="btn btn-primary mt-3">Go Back</a>
                            </div>
                        </div>
                    @else
                        <h4 class="font-weight-bold text-muted mb-4 text-uppercase">Hit the ball to pick a player</h4>

                        <!-- Cricket Scene -->
                        <div class="scene" id="scene">
                            <svg class="scene-svg" viewBox="0 0 640 340" preserveAspectRatio="none" aria-hidden="true">
                                <defs>
                                    <linearGradient id="skyGrad" x1="0" y1="0" x2="0"
                                        y2="1">
                                        <stop offset="0" stop-color="#1e293b" />
                                        <stop offset="1" stop-color="#0f172a" />
                                    </linearGradient>
                                    <linearGradient id="grassGrad" x1="0" y1="0" x2="0"
                                        y2="1">
                                        <stop offset="0" stop-color="#14532d" />
                                        <stop offset="1" stop-color="#166534" />
                                    </linearGradient>
                                </defs>

                                <!-- Background -->
                                <rect width="640" height="340" fill="url(#skyGrad)" />
                                <rect y="250" width="640" height="90" fill="url(#grassGrad)" />
                                <rect y="296" width="640" height="44" fill="#c8a66a" opacity="0.92" />
                                <line x1="120" y1="296" x2="120" y2="340" stroke="#fff"
                                    stroke-width="2" opacity="0.7" />

                                <!-- Stumps -->
                                <g fill="#f3e2b3">
                                    <rect x="52" y="236" width="5" height="62" rx="1" />
                                    <rect x="62" y="236" width="5" height="62" rx="1" />
                                    <rect x="72" y="236" width="5" height="62" rx="1" />
                                    <rect x="51" y="233" width="13" height="3" rx="1" />
                                    <rect x="65" y="233" width="13" height="3" rx="1" />
                                </g>

                                <!-- Batsman -->
                                <g id="batsman">
                                    <!-- Pads -->
                                    <rect x="158" y="228" width="18" height="68" rx="5" fill="#f1f5f9"
                                        stroke="#cbd5e1" />
                                    <rect x="184" y="228" width="18" height="68" rx="5" fill="#f1f5f9"
                                        stroke="#cbd5e1" />
                                    <!-- Shoes -->
                                    <rect x="153" y="294" width="26" height="9" rx="4" fill="#111827" />
                                    <rect x="182" y="294" width="26" height="9" rx="4" fill="#111827" />
                                    <!-- Trousers -->
                                    <rect x="160" y="205" width="40" height="30" rx="6" fill="#f8fafc" />
                                    <!-- Shirt -->
                                    <rect x="155" y="148" width="52" height="68" rx="13" fill="#be212a" />
                                    <!-- Head + helmet -->
                                    <circle cx="181" cy="128" r="15" fill="#e0b48f" />
                                    <path d="M164 126 Q164 105 181 105 Q199 105 199 126 L199 121 Q181 112 164 121 Z"
                                        fill="#111827" />
                                    <path d="M187 124 H203 M187 130 H203 M187 136 H203 M199 122 V138" stroke="#9ca3af"
                                        stroke-width="1.6" fill="none" />
                                    <!-- Upper arm -->
                                    <line x1="190" y1="162" x2="215" y2="185" stroke="#be212a"
                                        stroke-width="12" stroke-linecap="round" />

                                    <!-- Bat (rotates around the gloves) -->
                                    <g id="bat" class="bat-group">
                                        <rect x="212" y="185" width="6" height="34" rx="2"
                                            fill="#111827" />
                                        <rect x="206" y="217" width="18" height="62" rx="4"
                                            fill="#d6a15c" stroke="#a16207" />
                                        <rect x="209" y="221" width="4" height="52" rx="2"
                                            fill="#f1d3a1" opacity="0.7" />
                                        <circle cx="215" cy="185" r="7.5" fill="#111827" />
                                    </g>
                                </g>
                            </svg>

                            <!-- Impact ring -->
                            <div class="impact" id="impact"></div>

                            <!-- The Ball -->
                            <div class="ball" id="ball">
                                <div class="ball-seam"></div>
                                <span id="displayNumber" style="font-size: 7px !important;">?</span>
                            </div>
                        </div>

                        <!-- Spin Button -->
                        <button id="spinBtn" class="btn btn-brand-red btn-lg px-5 py-3 mt-4 font-weight-bold shadow-lg"
                            style="border-radius: 30px; font-size: 20px; letter-spacing: 2px;">
                            <i class="fas fa-play mr-2"></i> SPIN
                        </button>

                        <!-- Action Button (Hidden initially) -->
                        <div id="actionArea" style="opacity: 0; pointer-events: none; transition: all 0.4s ease;">
                            <a href="#" id="viewDetailsBtn"
                                class="btn btn-lg btn-success mt-4 px-5 font-weight-bold shadow"
                                style="border-radius: 30px; animation: pulse 2s infinite;">
                                <i class="fas fa-user-plus mr-2"></i> View Player & Assign
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
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

        /* ---------- Scene ---------- */
        .scene {
            position: relative;
            width: 100%;
            max-width: 640px;
            aspect-ratio: 640 / 340;
            margin: 10px auto 0;
            border: 4px solid var(--brand-secondary);
            border-radius: 16px;
            overflow: hidden;
            background: #0f172a;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        }

        .scene-svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            display: block;
        }

        .bat-group {
            transform-box: view-box;
            transform-origin: 215px 185px;
            transform: rotate(20deg);
        }

        /* ---------- Ball ---------- */
        .ball {
            position: absolute;
            left: 0;
            top: 0;
            border-radius: 50%;
            background: radial-gradient(circle at 32% 28%, #ef4b55, #be212a 55%, #7f1219);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Courier New', Courier, monospace;
            font-weight: 900;
            user-select: none;
            z-index: 3;
            will-change: transform;
            width: 64px;
            height: 64px;
        }

        .ball span {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: 0 4px;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.6);
        }

        .ball-seam {
            position: absolute;
            inset: 7%;
            border: 2px dashed rgba(255, 255, 255, 0.6);
            border-radius: 50%;
        }

        .ball.flying .ball-seam {
            animation: seamSpin .3s linear infinite;
        }

        .ball.landed {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.9), 0 0 40px rgba(16, 185, 129, 0.7);
        }

        /* ---------- Impact ring ---------- */
        .impact {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
            height: 80px;
            border: 4px solid #fbbf24;
            border-radius: 50%;
            opacity: 0;
            pointer-events: none;
            z-index: 4;
        }

        @keyframes seamSpin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
            }

            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 15px rgba(40, 167, 69, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }
    </style>
@endsection

@section('script')
    <script>
        const pendingPlayers = @json($pendingPlayers);

        const scene = document.getElementById('scene');
        const ball = document.getElementById('ball');
        const displayNumber = document.getElementById('displayNumber');
        const bat = document.getElementById('bat');
        const impact = document.getElementById('impact');
        const spinBtn = document.getElementById('spinBtn');
        const actionArea = document.getElementById('actionArea');

        const BASE_W = 640;
        const BALL = 64;
        const START = {
            x: 610,
            y: 110,
            k: 0.7
        };
        const BOUNCE = {
            x: 430,
            y: 268,
            k: 0.95
        };
        const CONTACT = {
            x: 283,
            y: 217,
            k: 1
        };
        const APEX = {
            x: 345,
            y: 50,
            k: 1.9
        };
        const LAND = {
            x: 390,
            y: 140,
            k: 2.6
        };

        const DELIVERY_MS = 1000;
        const FLIGHT_MS = 1300;

        let isSpinning = false;
        let ballState = {
            ...START
        };
        let currentLabel = '?';

        const scale = () => scene.clientWidth / BASE_W;
        const labelOf = (p) => (p.player_number ? p.player_number : p.name);

        function pos(p) {
            const s = scale();
            const size = BALL * s;
            return `translate(${p.x * s - size / 2}px, ${p.y * s - size / 2}px) scale(${p.k})`;
        }

        function sizeBall() {
            const s = scale();
            ball.style.width = ball.style.height = (BALL * s) + 'px';
            setLabel(currentLabel);
        }

        function setLabel(text) {
            currentLabel = String(text);
            displayNumber.style.fontSize = '7px';
            displayNumber.textContent = currentLabel;
        }

        function placeBall(p) {
            ballState = {
                ...p
            };
            ball.style.transform = pos(p);
        }

        async function play(el, frames, duration, easing = 'linear') {
            const anim = el.animate(frames, {
                duration,
                easing,
                fill: 'forwards'
            });
            await anim.finished;
            const last = frames[frames.length - 1];
            if (last.transform !== undefined) el.style.transform = last.transform;
            if (last.opacity !== undefined) el.style.opacity = last.opacity;
            anim.cancel();
        }

        function burst() {
            const s = scale();
            const size = 80 * s;
            impact.style.width = impact.style.height = size + 'px';
            const x = CONTACT.x * s - size / 2;
            const y = CONTACT.y * s - size / 2;
            impact.animate([{
                    transform: `translate(${x}px, ${y}px) scale(0.2)`,
                    opacity: 1
                },
                {
                    transform: `translate(${x}px, ${y}px) scale(1.8)`,
                    opacity: 0
                }
            ], {
                duration: 420,
                easing: 'ease-out'
            });

            scene.animate([{
                    transform: 'translate(0, 0)'
                },
                {
                    transform: 'translate(-4px, 2px)'
                },
                {
                    transform: 'translate(4px, -2px)'
                },
                {
                    transform: 'translate(0, 0)'
                }
            ], {
                duration: 180
            });
        }

        sizeBall();
        placeBall(START);
        window.addEventListener('resize', () => {
            sizeBall();
            placeBall(ballState);
        });

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        spinBtn.addEventListener('click', async function() {
            if (isSpinning || pendingPlayers.length === 0) return;

            isSpinning = true;
            spinBtn.disabled = true;
            spinBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> SPINNING...';

            actionArea.style.opacity = '0';
            actionArea.style.pointerEvents = 'none';

            const winner = pendingPlayers[Math.floor(Math.random() * pendingPlayers.length)];

            if (reduceMotion) {
                setLabel(labelOf(winner));
                finish(winner);
                return;
            }

            ball.classList.remove('landed');
            if (ballState.k > 1) await play(ball, [{
                opacity: 1
            }, {
                opacity: 0
            }], 180);
            placeBall(START);
            setLabel('?');
            await play(ball, [{
                opacity: 0
            }, {
                opacity: 1
            }], 180);

            const t0 = performance.now();
            let running = true;
            let last = null;
            (function tick() {
                if (!running) return;
                let p;
                do {
                    p = pendingPlayers[Math.floor(Math.random() * pendingPlayers.length)];
                } while (pendingPlayers.length > 1 && p === last);
                last = p;
                setLabel(labelOf(p));

                const now = performance.now() - t0;
                const delay = now < DELIVERY_MS ? 45 : 45 + ((now - DELIVERY_MS) / FLIGHT_MS) * 200;
                setTimeout(tick, delay);
            })();

            ball.classList.add('flying');

            const batP = play(bat, [{
                    transform: 'rotate(20deg)',
                    offset: 0,
                    easing: 'ease-out'
                },
                {
                    transform: 'rotate(125deg)',
                    offset: 0.3,
                    easing: 'linear'
                },
                {
                    transform: 'rotate(125deg)',
                    offset: 0.62,
                    easing: 'ease-in'
                },
                {
                    transform: 'rotate(-65deg)',
                    offset: 0.77,
                    easing: 'linear'
                },
                {
                    transform: 'rotate(-125deg)',
                    offset: 1
                }
            ], 1300);

            const ballP = (async () => {
                await play(ball, [{
                        transform: pos(START),
                        offset: 0,
                        easing: 'ease-in'
                    },
                    {
                        transform: pos(BOUNCE),
                        offset: 0.6,
                        easing: 'ease-out'
                    },
                    {
                        transform: pos(CONTACT),
                        offset: 1
                    }
                ], DELIVERY_MS);

                burst();

                await play(ball, [{
                        transform: pos(CONTACT),
                        offset: 0,
                        easing: 'ease-out'
                    },
                    {
                        transform: pos(APEX),
                        offset: 0.45,
                        easing: 'ease-in'
                    },
                    {
                        transform: pos(LAND),
                        offset: 1
                    }
                ], FLIGHT_MS);
                ballState = {
                    ...LAND
                };
            })();

            await Promise.all([batP, ballP]);
            running = false;

            setLabel(labelOf(winner));
            ball.classList.remove('flying');
            ball.classList.add('landed');
            ball.animate([{
                    transform: pos(LAND)
                },
                {
                    transform: pos({
                        ...LAND,
                        k: LAND.k * 1.1
                    })
                },
                {
                    transform: pos(LAND)
                }
            ], {
                duration: 280,
                easing: 'ease-out'
            });

            play(bat, [{
                transform: 'rotate(-125deg)'
            }, {
                transform: 'rotate(20deg)'
            }], 500, 'ease-in-out');

            finish(winner);
        });

        function finish(winner) {
            isSpinning = false;
            spinBtn.disabled = false;
            spinBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i> SPIN AGAIN';

            const assignRoute =
                "{{ route('auction.show-assign', [$tournament->id, 'PLAYER_ID']) }}?type={{ $spinType ?? 'pending' }}";
            document.getElementById('viewDetailsBtn').href = assignRoute.replace('PLAYER_ID', winner.id);

            actionArea.style.opacity = '1';
            actionArea.style.pointerEvents = 'auto';
        }
    </script>
@endsection
