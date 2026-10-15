<?php $__env->startSection('title'); ?>
    <?php echo e(__('tournaments')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo e(__('create_and_manage') . ' ' . __('tournaments')); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-dark">
                            <a href="<?php echo e(route('home')); ?>" class="text-dark"><i
                                    class="fas fa-home mr-1"></i><?php echo e(__('dashboard')); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><i
                                class="nav-icon fas fa-newspaper mr-1"></i><?php echo e(__('tournaments')); ?>

                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tournament-create')): ?>
                    <div class="col-md-12 d-flex justify-content-end">
                        <!-- <button id="toggleButton" class="btn btn-primary mb-3 ml-1"><i
                                                class="fas fa-plus-circle mr-2"></i></button> -->
                        <a href="<?php echo e(route('tournaments.create')); ?>" class="btn btn-primary mb-3 ml-1">
                            <i class="fas fa-plus-circle"></i> <?php echo e(__('create') . ' ' . __('tournament')); ?>

                        </a>
                    </div>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tournament-list')): ?>
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo e(__('tournaments') . ' ' . __('list')); ?></h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="tournaments_list_table" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Logo</th>
                                            <th>Name</th>
                                            <th>Short Code</th>
                                            <th>Venue & City</th>
                                            <th>From - To</th>
                                            <th>Prize Amount</th>
                                            <th>Player Registration Amount</th>
                                            <th>Status</th>
                                            <th>Organizer</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>

                                                <td>
                                                    <?php if($tournament->logo): ?>
                                                        <img src="<?php echo e(asset('storage/' . $tournament->logo)); ?>" width="50" height="50"
                                                            style="object-fit:cover;border-radius:6px;">
                                                    <?php else: ?>
                                                        <span class="text-muted">No logo</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td><?php echo e($tournament->name); ?></td>

                                                <td><?php echo e($tournament->short_code); ?></td>

                                                <td><?php echo e($tournament->venue); ?><?php echo e($tournament->city ? ', ' . $tournament->city : ''); ?>

                                                </td>

                                                <td>
                                                    <?php echo e(\Carbon\Carbon::parse($tournament->start_date)->format('d F, Y')); ?>

                                                    —
                                                    <?php echo e($tournament->end_date ? \Carbon\Carbon::parse($tournament->end_date)->format('d F, Y') : 'N/A'); ?>

                                                </td>

                                                <td>₹ <?php echo e(number_format($tournament->prize_amount, 0, '.', ',')); ?></td>

                                                <td>
                                                    <?php if($tournament->is_pr_free): ?>
                                                        <span class="badge bg-success">Free</span>
                                                    <?php else: ?>
                                                        ₹ <?php echo e(number_format($tournament->pr_amount, 0, '.', ',')); ?>

                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php if($tournament->status): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>

                                                <?php
                                                    $organizer_name = App\Models\Admin::where('id', $tournament->organizer_id)->first();
                                                ?>
                                                <td><?php echo e($organizer_name->username ?? 'N/A'); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('tournaments.show', $tournament->id)); ?>"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="<?php echo e(route('tournaments.edit', $tournament->id)); ?>"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="<?php echo e(route('tournaments.destroy', $tournament->id)); ?>" method="POST"
                                                        style="display:inline-block"
                                                        onsubmit="return confirm('Are you sure to delete?')">

                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>

                                                        <button class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>


                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <!-- <tr>
                                                                        <td colspan="8" class="text-center">No tournaments found</td>
                                                                    </tr> -->
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            //data table
            new DataTable('#tournaments_list_table', {
                paging: true,
                searching: true,
                ordering: true,
                scrollX: true,
                language: {
                    emptyTable: "No tournaments found"
                }
            });

        });

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Vinothbabu\AuctionHub\resources\views/tournaments/index.blade.php ENDPATH**/ ?>