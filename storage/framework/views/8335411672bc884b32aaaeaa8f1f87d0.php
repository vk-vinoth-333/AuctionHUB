<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <style>
        @media (max-width: 425px) {
            .navbar .nav-link {
                padding: 0.3rem 0.5rem !important;
            }
            .navbar .user-image {
                max-width: 25px;
                max-height: 25px;
            }
        }
        @media (max-width: 320px) {
            .navbar .nav-link {
                padding: 0.2rem 0.3rem !important;
                width: min-content;
            }
            .navbar .user-image {
                max-width: 10px;
                max-height: 10px;
            }
            .user-image {
                display: none;
            }
        }
    </style>
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)" role="button"><i class="fas fa-bars text-dark"></i></a>
        </li>
        <li class="nav-item my-auto ml-2">
            <span class="badge" style="border-radius: 8px!important;padding:8px; color:<?php echo e($setting['primary_color']); ?>;border:1px solid <?php echo e($setting['primary_color']); ?>"><?php echo e($setting['app_version']); ?></span>
        </li>
        <?php if(env('DEMO_MODE')): ?>
            <li class="nav-item my-auto ml-2">
                <span class="badge badge-danger" style="border-radius: 8px!important;padding:8px">Demo mode</span>
            </li>
        <?php endif; ?>
    </ul>
    <?php
        $setting = getSetting();
    ?>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown user-menu">
            <div class="row">
                <label class="current_language">
                    <?php echo e(empty(session('language_name')) ? 'English' : session('language_name')); ?>

                </label>
                <div class="dropdown navbar_dropdown mr-2">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle text-white" data-toggle="dropdown">
                        <i class="fas fa-language text-white mt-2"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="languageDropdown" aria-labelledby="languageDropdown">
                        <div class="scrollable-menu">
                            <?php $__currentLoopData = get_language(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item" href="<?php echo e(url('set-language') . '/' . $language->code); ?>">
                                    <?php echo e($language->language); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <div class="dropdown navbar_dropdown mr-4">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle text-white" data-toggle="dropdown">
                        <?php if(Auth::user()->image): ?>
                            <img src="<?php echo e(url(Storage::url(Auth::user()->image))); ?>" class="user-image img-circle elevation-2" alt="image">
                        <?php endif; ?>
                        Hi, <?php echo e(Auth::user()->username); ?>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="<?php echo e(route('edit-profile')); ?>" class="dropdown-item">
                            <em class="fas fa-user mr-2"></em> <?php echo e(__('edit') . ' ' . __('profile')); ?>

                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo e(url('logout')); ?>" class="dropdown-item">
                            <em class="fas fa-power-off mr-2"></em> <?php echo e(__('logout')); ?>

                        </a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<?php /**PATH C:\Vinothbabu\AuctionHub\resources\views/layouts/header.blade.php ENDPATH**/ ?>