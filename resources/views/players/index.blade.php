@extends('layouts.main')

@section('title')
    {{ __('players') }}
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('create_and_manage') . ' ' . __('players') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-dark">
                            <a href="{{ route('home') }}" class="text-dark"><i
                                    class="fas fa-home mr-1"></i>{{ __('dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active brand-red"><i
                                class="nav-icon fas fa-user-friends mr-1"></i>{{ __('players') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between mb-3">
                    <div>
                        <!-- Bulk Action Dropdown -->
                        <div class="input-group" style="width: 300px; display: none;" id="bulkActionWrapper">
                            <select class="form-control" id="bulkActionSelect">
                                <option value="">Bulk Actions...</option>
                                <option value="player_status:sold">Mark as Sold</option>
                                <option value="player_status:unsold">Mark as Unsold</option>
                                <option value="player_status:pending">Mark as Pending</option>
                                <option value="payment_status:paid">Mark as Paid</option>
                                <option value="payment_status:not_paid">Mark as Not Paid</option>
                                <option value="status:1">Mark as Active</option>
                                <option value="status:0">Mark as Inactive</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="applyBulkAction">Apply</button>
                            </div>
                        </div>
                    </div>

                    @can('player-create')
                        <a href="{{ route('players.create') }}" class="btn btn-primary ml-1">
                            <i class="fas fa-plus-circle"></i> {{ __('create') . ' ' . __('player') }}
                        </a>
                    @endcan
                </div>

                @can('player-list')
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('players') . ' ' . __('list') }}</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="players_list_table" class="table table-bordered table-striped nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px;">
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th>#</th>
                                            <th>{{ __('photo') }}</th>
                                            <th>{{ __('player_name') }}</th>
                                            <th>{{ __('number') }}</th>
                                            <th>{{ __('phone') }}</th>
                                            <th>{{ __('team') }}</th>
                                            <th>{{ __('tournament') }}</th>
                                            <th>{{ __('role') }}</th>
                                            <th>{{ __('batting_style') }}</th>
                                            <th>{{ __('bowling_style') }}</th>
                                            <th>{{ __('base_price') }}</th>
                                            <th>{{ __('sold_price') }}</th>
                                            <th>{{ __('proof') }}</th>
                                            <th>{{ __('payment') }}</th>
                                            <th>{{ __('player_status') }}</th>
                                            <th>{{ __('payment_status') }}</th>
                                            <th>{{ __('status') }}</th>
                                            <th class="text-center">{{ __('actions') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($players as $key => $player)
                                            <tr id="row-{{ $player->id }}">
                                                <td class="text-center align-middle">
                                                    <input type="checkbox" class="row-checkbox" value="{{ $player->id }}">
                                                </td>

                                                <td>{{ $key + 1 }}</td>

                                                {{-- Photo --}}
                                                <td>
                                                    @if ($player->photo)
                                                        <img src="{{ asset('storage/' . $player->photo) }}" width="40"
                                                            height="40" class="rounded player-media-thumb"
                                                            style="cursor:pointer"
                                                            data-img="{{ asset('storage/' . $player->photo) }}"
                                                            data-title="{{ $player->name }} - {{ __('photo') }}"
                                                            data-toggle="modal" data-target="#mediaViewerModal">
                                                    @else
                                                        <div class="team-avatar"
                                                            style="width: 40px; height: 40px; font-size: 14px;">
                                                            {{ strtoupper(substr($player->name, 0, 2)) }}
                                                        </div>
                                                    @endif
                                                </td>

                                                <td><span class="font-weight-bold text-dark">{{ $player->name }}</span></td>

                                                <td>{{ $player->player_number ?? '-' }}</td>

                                                <td>{{ $player->phone ?? '-' }}</td>

                                                <td>
                                                    @if ($player->team)
                                                        <span
                                                            class="badge badge-light border text-dark px-2 py-1">{{ $player->team->name }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <td>{{ $player->tournament->name ?? '-' }}</td>

                                                {{-- Role (int → label) --}}
                                                <td>{{ $player->detail->role_label ?? '-' }}</td>

                                                {{-- Batting Style --}}
                                                <td>
                                                    @php
                                                        $battingStyle = $player->detail->batting_style ?? null;
                                                    @endphp
                                                    @if ($battingStyle === 'right_handed')
                                                        {{ __('right_handed') }}
                                                    @elseif ($battingStyle === 'left_handed')
                                                        {{ __('left_handed') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- Bowling Style --}}
                                                <td>
                                                    @php
                                                        $bowlingStyle = $player->detail->bowling_style ?? null;
                                                    @endphp
                                                    @if ($bowlingStyle === 'right')
                                                        {{ __('right') }}
                                                    @elseif ($bowlingStyle === 'left')
                                                        {{ __('left') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($player->detail->base_price ?? null)
                                                        ₹ {{ number_format((float) $player->detail->base_price) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($player->detail->sold_price ?? null)
                                                        <span class="font-weight-bold" style="color: #dd6b20;">₹ {{ number_format((float) $player->detail->sold_price) }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- Original Proof --}}
                                                <td>
                                                    @php
                                                        $proof = $player->detail->original_proof ?? null;
                                                    @endphp
                                                    @if ($proof)
                                                        @if (Str::endsWith(strtolower($proof), ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                                            <img src="{{ asset('storage/' . $proof) }}" width="40"
                                                                height="40" class="rounded player-media-thumb"
                                                                style="cursor:pointer"
                                                                data-img="{{ asset('storage/' . $proof) }}"
                                                                data-title="{{ $player->name }} - {{ __('original_proof') }}"
                                                                data-toggle="modal" data-target="#mediaViewerModal">
                                                        @else
                                                            <a href="{{ asset('storage/' . $proof) }}" target="_blank"
                                                                class="btn btn-sm btn-info" title="{{ __('original_proof') }}">
                                                                <i class="fas fa-file"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>

                                                {{-- Payment Screenshot --}}
                                                <td>
                                                    @php
                                                        $paymentScreenshot =
                                                            $player->detail->payment_screenshot ?? null;
                                                    @endphp
                                                    @if ($paymentScreenshot)
                                                        @if (Str::endsWith(strtolower($paymentScreenshot), ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                                            <img src="{{ asset('storage/' . $paymentScreenshot) }}"
                                                                width="40" height="40" class="rounded player-media-thumb"
                                                                style="cursor:pointer"
                                                                data-img="{{ asset('storage/' . $paymentScreenshot) }}"
                                                                data-title="{{ $player->name }} - {{ __('payment_screenshot') }}"
                                                                data-toggle="modal" data-target="#mediaViewerModal">
                                                        @else
                                                            <a href="{{ asset('storage/' . $paymentScreenshot) }}"
                                                                target="_blank" class="btn btn-sm btn-info"
                                                                title="{{ __('payment_screenshot') }}">
                                                                <i class="fas fa-file"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>

                                                {{-- Player Status Toggle --}}
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <input type="checkbox" class="toggle-switch ajax-toggle"
                                                            data-id="{{ $player->id }}" data-field="player_status"
                                                            data-on="sold" data-off="unsold"
                                                            {{ $player->player_status === 'sold' ? 'checked' : '' }}>
                                                        <span
                                                            class="status-label fw-bold {{ $player->player_status === 'sold' ? 'text-success' : 'text-warning' }}"
                                                            style="font-size: 12px;">
                                                            {{ ucfirst($player->player_status) }}
                                                        </span>
                                                    </div>
                                                </td>

                                                {{-- Payment Status Toggle --}}
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <input type="checkbox" class="toggle-switch ajax-toggle"
                                                            data-id="{{ $player->id }}" data-field="payment_status"
                                                            data-on="paid" data-off="not_paid"
                                                            {{ $player->payment_status === 'paid' ? 'checked' : '' }}>
                                                        <span
                                                            class="status-label fw-bold {{ $player->payment_status === 'paid' ? 'text-success' : 'text-danger' }}"
                                                            style="font-size: 12px;">
                                                            {{ $player->payment_status === 'paid' ? 'Paid' : 'Not Paid' }}
                                                        </span>
                                                    </div>
                                                </td>

                                                {{-- Active Status Toggle --}}
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <input type="checkbox" class="toggle-switch ajax-toggle"
                                                            data-id="{{ $player->id }}" data-field="status" data-on="1"
                                                            data-off="0" {{ $player->status ? 'checked' : '' }}>
                                                        <span
                                                            class="status-label fw-bold {{ $player->status ? 'text-success' : 'text-danger' }}"
                                                            style="font-size: 12px;">
                                                            {{ $player->status ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </div>
                                                </td>

                                                {{-- Actions --}}
                                                <td class="text-center">
                                                    <a href="{{ route('players.show', $player->id) }}"
                                                        class="btn btn-sm btn-primary" title="{{ __('view') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('players.edit', $player->id) }}"
                                                        class="btn btn-sm btn-primary" title="{{ __('edit') }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('players.destroy', $player->id) }}" method="POST"
                                                        style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            title="{{ __('delete') }}"
                                                            onclick="return confirm('{{ __('are_you_sure') }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </section>

    {{-- Shared Media Viewer Modal --}}
    <div class="modal fade" id="mediaViewerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="mediaViewerModalLabel">
                        <i class="fas fa-image mr-2"></i> {{ __('preview') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="this.blur()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="background-color: #f4f6f9; padding: 20px;">
                    <img src="" id="mediaViewerImage" class="img-fluid rounded shadow-sm" alt="preview" style="max-height: 75vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>

        .team-avatar {
            background: #f3f4f6;
            color: #000;
            border: 2px solid #f3c9cc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            border-radius: 50%;
        }

        .switchery {
            width: 32px;
            height: 18px;
            flex-shrink: 0;
        }

        .switchery>small {
            width: 18px;
            height: 18px;
        }

        .row-selected {
            background-color: #fdf2f3 !important;
        }
    </style>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>

    <script>
        let table;

        document.addEventListener('DOMContentLoaded', function() {
            // DataTable Initialization
            table = new DataTable('#players_list_table', {
                paging: true,
                searching: true,
                ordering: true,
                scrollX: true,
                pageLength: 10,
                language: {
                    emptyTable: "{{ __('could_not_find_data') }}"
                },
                drawCallback: function() {
                    initSwitchery();
                },
                columnDefs: [{
                    orderable: false,
                    targets: 0
                }]
            });

            initSwitchery();

            function initSwitchery() {
                document.querySelectorAll('.ajax-toggle').forEach(function(el) {
                    let switcheryWrapper = el.nextElementSibling;

                    if (switcheryWrapper && switcheryWrapper.classList.contains('switchery')) {
                        switcheryWrapper.parentNode.insertBefore(el, switcheryWrapper);
                        switcheryWrapper.remove();
                    }

                    let sw = new Switchery(el, {
                        size: 'small',
                        color: '#47C363',
                        secondaryColor: '#EB4141',
                        jackColor: '#fff',
                        jackSecondaryColor: '#fff'
                    });

                    el.onchange = function() {
                        let id = this.dataset.id;
                        let field = this.dataset.field;
                        let value = this.checked ? this.dataset.on : this.dataset.off;

                        let label = this.nextElementSibling;
                        if (label && label.classList.contains('status-label')) {
                            if (value === 'sold' || value === 'paid' || value === '1') {
                                label.className = 'status-label fw-bold text-success';
                            } else if (value === 'unsold') {
                                label.className = 'status-label fw-bold text-warning';
                            } else {
                                label.className = 'status-label fw-bold text-danger';
                            }

                            let displayValue = value.replace('_', ' ');
                            if (field === 'status') displayValue = value === '1' ? 'Active' :
                            'Inactive';
                            label.textContent = displayValue.charAt(0).toUpperCase() + displayValue
                                .slice(1);
                        }

                        updateStatus(id, field, value, this);
                    };
                });
            }

            function updateStatus(id, field, value, element) {
                fetch(`{{ route('players.update-status-global') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: id,
                            field: field,
                            value: value
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showSuccessToast(data.message || 'Player updated successfully');
                        } else {
                            showErrorToast(data.message || 'Failed to update status');
                            initSwitchery();
                        }
                    })
                    .catch((error) => {
                        showErrorToast('Server error occurred.');
                        initSwitchery();
                        console.error(error);
                    });
            }

            // Media preview modal
            $(document).on('click', '[data-toggle="modal"][data-target="#mediaViewerModal"]', function() {
                $('#mediaViewerImage').attr('src', $(this).data('img'));
                $('#mediaViewerModalLabel').text($(this).data('title') || '{{ __('preview') }}');
            });

            // Bulk Action Logic
            const selectAll = document.getElementById('selectAll');
            const bulkWrapper = document.getElementById('bulkActionWrapper');

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const isChecked = this.checked;
                    document.querySelectorAll('.row-checkbox').forEach(cb => {
                        cb.checked = isChecked;
                        cb.closest('tr').classList.toggle('row-selected', isChecked);
                    });
                    toggleBulkWrapper();
                });
            }

            $(document).on('change', '.row-checkbox', function() {
                $(this).closest('tr').toggleClass('row-selected', this.checked);

                const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
                const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked').length;
                if (selectAll) {
                    selectAll.checked = totalCheckboxes === checkedCheckboxes && totalCheckboxes > 0;
                }

                toggleBulkWrapper();
            });

            function toggleBulkWrapper() {
                if (!bulkWrapper) return;
                const checked = document.querySelectorAll('.row-checkbox:checked').length;
                bulkWrapper.style.display = checked > 0 ? 'flex' : 'none';
            }

            const applyBulkAction = document.getElementById('applyBulkAction');
            if (applyBulkAction) {
                applyBulkAction.addEventListener('click', function() {
                    const action = document.getElementById('bulkActionSelect').value;
                    if (!action) return showErrorToast('Please select an action');

                    const [field, value] = action.split(':');
                    const ids = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb
                        .value);

                    if (ids.length === 0) return;

                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    this.disabled = true;

                    fetch(`{{ route('players.bulk-update-status-global') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ids: ids,
                                field: field,
                                value: value
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                showSuccessToast(data.message || 'Bulk update successful');
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                showErrorToast(data.message || 'Bulk update failed');
                                this.innerHTML = 'Apply';
                                this.disabled = false;
                            }
                        })
                        .catch((error) => {
                            showErrorToast('Server error.');
                            this.innerHTML = 'Apply';
                            this.disabled = false;
                            console.error(error);
                        });
                });
            }
        });
    </script>
@endsection
