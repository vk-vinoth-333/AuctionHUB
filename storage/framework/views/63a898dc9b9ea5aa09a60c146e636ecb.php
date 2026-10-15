<?php $__env->startSection('title'); ?>
    <?php echo e(__('teams')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo e(__('create_and_manage') . ' ' . __('teams')); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-dark">
                            <a href="<?php echo e(route('home')); ?>" class="text-dark"><i
                                    class="fas fa-home mr-1"></i><?php echo e(__('dashboard')); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><i class="nav-icon fas fa-newspaper mr-1"></i><?php echo e(__('teams')); ?>

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
                        <a href="<?php echo e(route('teams.create')); ?>" class="btn btn-primary mb-3 ml-1">
                            <i class="fas fa-plus-circle"></i> <?php echo e(__('create') . ' ' . __('team')); ?>

                        </a>
                    </div>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tournament-list')): ?>
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo e(__('teams') . ' ' . __('list')); ?></h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="teams_list_table" class="table table-bordered table-striped nowrap"
                                    style="width:100%">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('logo')); ?></th>
                                            <th><?php echo e(__('team_name')); ?></th>
                                            <th><?php echo e(__('short_name')); ?></th>
                                            <th><?php echo e(__('tournament')); ?></th>
                                            <th><?php echo e(__('owner')); ?></th>
                                            <th><?php echo e(__('phone')); ?></th>
                                            <th><?php echo e(__('status')); ?></th>
                                            <th class="text-center"><?php echo e(__('actions')); ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <tr>

                                                <td><?php echo e($key + 1); ?></td>

                                                <td>
                                                    <?php if($team->logo): ?>
                                                        <img src="<?php echo e(asset('storage/' . $team->logo)); ?>" width="40" height="40"
                                                            class="rounded">
                                                    <?php else: ?>
                                                        <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td><?php echo e($team->name); ?></td>

                                                <td><?php echo e($team->short_name ?? '-'); ?></td>

                                                <td><?php echo e($team->tournament->name ?? '-'); ?></td>

                                                <td><?php echo e($team->owner_name ?? '-'); ?></td>

                                                <td><?php echo e($team->contact_phone ?? '-'); ?></td>

                                                <td>
                                                    <?php if($team->status): ?>
                                                        <span class="badge badge-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-center">

                                                    <a href="<?php echo e(route('teams.show', $team->id)); ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="<?php echo e(route('teams.edit', $team->id)); ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="<?php echo e(route('teams.destroy', $team->id)); ?>" method="POST"
                                                        style="display:inline-block">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>

                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>

                                                    </form>

                                                </td>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
            new DataTable('#teams_list_table', {
                paging: true,
                searching: true,
                ordering: true,
                scrollX: true,
                language: {
                    emptyTable: "No teams found"
                }
            });

        });

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Vinothbabu\AuctionHub\resources\views/teams/index.blade.php ENDPATH**/ ?>