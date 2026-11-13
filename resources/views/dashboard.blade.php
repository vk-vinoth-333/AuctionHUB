@extends('layouts.main')

@section('title')
    {{ __('dashboard') }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('dashboard') }}</h1>
                </div>
                <div class="col-sm-6">
                    {{-- Tournament filter --}}
                    <form method="GET" action="{{ url()->current() }}" class="float-sm-right mt-2 mt-sm-0">
                        <select name="tournament_id" class="form-control form-control-sm brand-select"
                            onchange="this.form.submit()">
                            <option value="">All Tournaments</option>
                            @foreach ($tournaments as $t)
                                <option value="{{ $t->id }}"
                                    {{ (int) $tournamentId === (int) $t->id ? 'selected' : '' }}>
                                    {{ $t->name }} ({{ $t->short_code }})
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- ===== Stat boxes ===== --}}
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ url('tournaments') }}" class="text-dark">
                        <div class="info-box shadow-sm border-0">
                            <span class="info-box-icon icon-black elevation-1"><i class="fas fa-trophy"></i></span>
                            <div class="info-box-content">
                                <span
                                    class="info-box-text text-muted text-uppercase text-xs font-weight-bold">Tournaments</span>
                                <span class="info-box-number text-xl font-weight-bold text-dark counter"
                                    data-count="{{ $countTournaments }}">{{ $countTournaments }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ url('teams') }}" class="text-dark">
                        <div class="info-box shadow-sm border-0">
                            <span class="info-box-icon icon-red elevation-1"><i class="fas fa-shield-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-muted text-uppercase text-xs font-weight-bold">Teams</span>
                                <span class="info-box-number text-xl font-weight-bold text-dark counter"
                                    data-count="{{ $countTeams }}">{{ $countTeams }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ url('players') }}" class="text-dark">
                        <div class="info-box shadow-sm border-0">
                            <span class="info-box-icon icon-slate elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-muted text-uppercase text-xs font-weight-bold">Total
                                    Players</span>
                                <span class="info-box-number text-xl font-weight-bold text-dark counter"
                                    data-count="{{ $countPlayers }}">{{ $countPlayers }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-sm border-0">
                        <span class="info-box-icon icon-gold elevation-1"><i class="fas fa-coins"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted text-uppercase text-xs font-weight-bold">Total Points
                                Spent</span>
                            <span class="info-box-number text-xl font-weight-bold text-dark counter"
                                data-count="{{ $totalSpent }}">{{ $totalSpent }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== Charts Row 1: Auction Progress & Roles ===== --}}
            <div class="row mb-3">
                <div class="col-md-4 col-sm-12">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h3 class="card-title font-weight-bold text-dark">Auction Progress</h3>
                        </div>
                        <div id="status_chart"></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h3 class="card-title font-weight-bold text-dark">Role-wise Players</h3>
                        </div>
                        <div id="role_chart"></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h3 class="card-title font-weight-bold text-dark">Registration Source</h3>
                        </div>
                        <div id="reg_source_chart"></div>
                    </div>
                </div>
            </div>

            {{-- ===== Teams + Top Buys ===== --}}
            <div class="row mb-3">
                <div class="col-md-8 col-sm-12">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h3 class="card-title font-weight-bold text-dark">Teams & Player Counts</h3>
                        </div>
                        <div class="card-body mt-2">
                            <div class="row">
                                @foreach ($teams as $team)
                                    @php
                                        $spent = (int) $team->spent_points;
                                        $total = $spent + (int) $team->available_points;
                                        $pct = $total > 0 ? round(($spent / $total) * 100) : 0;
                                    @endphp
                                    <div class="col-lg-4 col-sm-6 col-12 mb-3">
                                        <div class="team-tile h-100">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="team-avatar">
                                                    {{ strtoupper(substr($team->name, 0, 2)) }}
                                                </div>
                                                <div class="min-w-0 ml-2">
                                                    <h6 class="font-weight-bold text-dark mb-0 text-truncate"
                                                        title="{{ $team->name }}">{{ $team->name }}</h6>
                                                    <span class="badge badge-dark">Pool {{ $team->pool ?? 'N/A' }}</span>
                                                </div>
                                            </div>

                                            <div class="team-row">
                                                <span><i class="fas fa-users mr-1 text-dark"></i> Players</span>
                                                <strong class="text-dark">{{ $team->player_count }}</strong>
                                            </div>
                                            <div class="team-row">
                                                <span><i class="fas fa-coins mr-1 brand-red"></i> Available</span>
                                                <span
                                                    class="point-badge">{{ number_format($team->available_points) }}</span>
                                            </div>
                                            <div class="mt-2">
                                                <div
                                                    class="d-flex justify-content-between text-xs text-muted font-weight-bold mb-1">
                                                    <span>Purse used</span><span>{{ $pct }}%</span>
                                                </div>
                                                <div class="progress purse-bar">
                                                    <div class="progress-bar" style="width: {{ $pct }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer bg-white text-center py-3">
                            <a href="{{ url('teams') }}" class="panel-link">View all teams <i
                                    class="fas fa-arrow-right ml-1 text-xs"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h3 class="card-title font-weight-bold text-dark">Top 5 Buys</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($topBuys as $index => $item)
                                    <div class="list-group-item d-flex align-items-center p-3">
                                        <div class="font-weight-bold text-muted mr-3"
                                            style="font-size: 1.2rem; width: 20px;">#{{ $index + 1 }}</div>
                                        <img src="{{ $item->photo ? asset('storage/' . $item->photo) : asset('images/favicon.png') }}"
                                            class="rounded-circle mr-3" width="45" height="45"
                                            style="object-fit:cover;">
                                        <div class="flex-grow-1 min-w-0">
                                            <h6 class="mb-0 font-weight-bold text-dark text-truncate">{{ $item->name }}
                                            </h6>
                                            <small class="text-muted">{{ $item->team->name ?? 'Unknown Team' }}</small>
                                        </div>
                                        <span class="point-badge ml-2">{{ number_format($item->sold_out_points) }}</span>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted">No players sold yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== Team Purse Chart (Full Width) ===== --}}
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h3 class="card-title font-weight-bold text-dark">Team Purse Distribution (Spent vs Available)
                            </h3>
                        </div>
                        <div id="team_purse_chart"></div>
                    </div>
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
            --brand-secondary-soft: #fdf2f3;
            --brand-secondary-line: #f3c9cc;
        }

        .brand-red {
            color: var(--brand-secondary) !important;
        }

        .brand-select {
            min-width: 220px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            font-weight: 600;
        }

        .brand-select:focus {
            border-color: var(--brand-secondary);
            box-shadow: 0 0 0 .15rem rgba(190, 33, 42, .15);
        }

        .info-box {
            transition: transform .2s ease, box-shadow .2s ease;
        }

        a:hover>.info-box {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .12) !important;
        }

        .info-box .info-box-icon {
            color: #fff;
        }

        .icon-black {
            background: var(--brand-primary);
        }

        .icon-red {
            background: var(--brand-secondary);
        }

        .icon-green {
            background: #16a34a;
        }

        .icon-slate {
            background: #475569;
        }

        .icon-gold {
            background: #b45309;
        }

        .min-w-0 {
            min-width: 0;
        }

        /* Teams */
        .team-tile {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px;
            position: relative;
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .team-tile::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--brand-primary), var(--brand-secondary));
        }

        .team-tile:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(0, 0, 0, .2);
        }

        .team-avatar {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #f3f4f6;
            color: var(--brand-primary);
            border: 2px solid var(--brand-secondary-line);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
        }

        .team-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-top: 1px dashed #e5e7eb;
            font-size: .85rem;
            font-weight: 600;
            color: #6b7280;
        }

        .point-badge {
            background: var(--brand-secondary-soft);
            color: var(--brand-secondary);
            font-weight: 800;
            font-size: 13px;
            padding: 3px 10px;
            border-radius: 20px;
            border: 1px solid var(--brand-secondary-line);
        }

        .purse-bar {
            height: 6px;
            border-radius: 6px;
            background: #f1f5f9;
        }

        .purse-bar .progress-bar {
            background: linear-gradient(90deg, var(--brand-primary), var(--brand-secondary));
            border-radius: 6px;
        }

        .panel-link {
            font-weight: 600;
            color: var(--brand-secondary);
        }

        .panel-link:hover {
            color: #9a1a22;
            text-decoration: underline;
        }

        .list-group-item {
            border-left: none;
            border-right: none;
        }

        .list-group-item:first-child {
            border-top: none;
        }
    </style>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript">
        // Counter animation
        $(".counter").each(function() {
            var $el = $(this);
            var target = Number($el.data('count')) || 0;
            $({
                c: 0
            }).animate({
                c: target
            }, {
                duration: 1600,
                easing: "swing",
                step: function(now) {
                    $el.text(Math.ceil(now).toLocaleString('en-IN'));
                },
                complete: function() {
                    $el.text(target.toLocaleString('en-IN'));
                }
            });
        });

        var noData = {
            text: 'No data available',
            align: 'center',
            verticalAlign: 'middle',
            style: {
                color: '#6b7280',
                fontSize: '14px'
            }
        };

        // 1. Auction Progress (Donut)
        var statusData = @json($statusChart);
        var totalPlayers = statusData.reduce(function(a, b) {
            return a + b.count;
        }, 0);

        new ApexCharts(document.getElementById('status_chart'), {
            chart: {
                type: 'donut',
                height: 320
            },
            series: statusData.map(i => i.count),
            labels: statusData.map(i => i.status),
            colors: statusData.map(i => i.color),
            noData: noData,
            stroke: {
                width: 2,
                colors: ['#fff']
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Players',
                                formatter: function() {
                                    return totalPlayers;
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'bottom'
            }
        }).render();

        // 2. Role-wise Players (Horizontal Bar)
        var roleData = @json($roleChart);
        new ApexCharts(document.getElementById('role_chart'), {
            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Players',
                data: roleData.map(i => i.players)
            }],
            labels: roleData.map(i => i.role),
            colors: ['#1e293b'],
            noData: noData,
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 6,
                    barHeight: '50%'
                }
            },
            xaxis: {
                categories: roleData.map(i => i.role)
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#fff']
                }
            }
        }).render();

        // 3. Registration Source (Pie)
        var regData = @json($regSourceChart);
        new ApexCharts(document.getElementById('reg_source_chart'), {
            chart: {
                type: 'pie',
                height: 320
            },
            series: regData.map(i => i.count),
            labels: regData.map(i => i.source),
            colors: ['#be212a', '#334155'],
            noData: noData,
            legend: {
                position: 'bottom'
            }
        }).render();

        // 4. Team Purse (Stacked Bar)
        var purseData = @json($teamPurseChart);
        new ApexCharts(document.getElementById('team_purse_chart'), {
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
                toolbar: {
                    show: false
                }
            },
            series: [{
                    name: 'Spent Points',
                    data: purseData.map(i => i.spent)
                },
                {
                    name: 'Available Points',
                    data: purseData.map(i => i.available)
                }
            ],
            xaxis: {
                categories: purseData.map(i => i.team)
            },
            colors: ['#be212a', '#e2e8f0'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '40%'
                }
            },
            noData: noData,
            legend: {
                position: 'top'
            }
        }).render();
    </script>
@endsection
