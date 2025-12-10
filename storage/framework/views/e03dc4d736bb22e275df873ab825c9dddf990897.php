

<?php $__env->startSection('content'); ?>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Stats Card -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="col-lg-12 col-md-12 col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            
                                            <i class="bx bxs-business" style="font-size: 3em;color:green;"></i>
                                            
                                        </div>
                                    </div>
                                    <span>Projects</span>
                                    <h3 class="card-title text-nowrap mb-1"><?php echo e($count); ?></h3>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <!-- Flash Messages -->
                <?php $__currentLoopData = ['success', 'delete', 'update']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(session()->has($msg)): ?>
                        <div
                            class="alert alert-<?php echo e($msg == 'update' ? 'warning' : ($msg == 'delete' ? 'danger' : 'success')); ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="bx bxs-x"
                                    style="font-size: 2em; color: <?php echo e($msg == 'update' ? 'orange' : ($msg == 'delete' ? 'red' : 'green')); ?>"></i>
                            </button>
                            <span><?php echo e(session($msg)); ?></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- Project Table -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Project Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <!-- Filter Form -->
                                    <form action="<?php echo e(route('project.index')); ?>" method="GET"
                                        style="display: flex; align-items: center;">
                                        <?php echo csrf_field(); ?>
                                        <label for="zone" style="margin-right: 10px;">Zone</label>
                                        <select name="zone" id="zone" class="form-control dynamic"
                                            data-dependent="woreda"
                                            style="display: inline-block;width:35%;margin-right:10px;">
                                            <option value="">Select Zone</option>
                                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($zone); ?>"
                                                    <?php echo e(request('zone') == $zone ? 'selected' : ''); ?>><?php echo e($zone); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                        <label for="woreda" style="margin-right: 10px;">Woreda/City</label>
                                        <select name="woreda" id="woreda" class="form-control"
                                            style="display: inline-block;width:35%;margin-right:10px;">
                                            <option value="">Select Woreda</option>
                                            <?php if(!empty($woredas)): ?>
                                                <?php $__currentLoopData = $woredas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $woreda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($woreda); ?>"
                                                        <?php echo e(request('woreda') == $woreda ? 'selected' : ''); ?>>
                                                        <?php echo e($woreda); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>

                                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                                    </form>
                                </div>
                                <div class="col-3 mb-3 align-content-center" style="text-align: right;">
                                    <a href="<?php echo e(route('project.create')); ?>" class="btn btn-sm btn-success">Add project</a>
                                </div>
                            </div>

                            <div class="table-responsive  table-strip">
                                <table class="table table-strip table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Zone</th>
                                            <th>Woreda/City</th>
                                            <th>Name</th>
                                            <th>Project Type</th>
                                            <th>Site</th>
                                            <th>Address</th>
                                            <th>Progression</th>
                                            <th>Community Participation</th>
                                            <th>Started Year</th>
                                            <th>Budget</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($report->id); ?></td>
                                                <td><?php echo e($report->zone); ?></td>
                                                <td><?php echo e($report->woreda_or_city); ?></td>
                                                <td><?php echo e($report->name); ?></td>
                                                <td><?php echo e($report->type); ?></td>
                                                <td><?php echo e($report->site); ?></td>
                                                <td><?php echo e($report->address); ?></td>
                                                <td><?php echo e($report->progression); ?></td>
                                                <td><?php echo e($report->community_participation); ?></td>
                                                <td><?php echo e($report->started_year); ?></td>
                                                <td><?php echo e(number_format($report->budget, 2)); ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" id="actionDropdown<?php echo e($report->id); ?>"
                                                            data-bs-toggle="dropdown">
                                                            Actions
                                                        </button>

                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="actionDropdown<?php echo e($report->id); ?>">

                                                            
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gujii-edit')): ?>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="<?php echo e(route('project.edit', $report->id)); ?>">
                                                                        Edit
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gujii-delete')): ?>
                                                                <li>
                                                                    <form action="<?php echo e(route('project.destroy', $report->id)); ?>"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure?');">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo method_field('DELETE'); ?>
                                                                        <button class="dropdown-item text-danger"
                                                                            type="submit">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            <?php endif; ?>

                                                            

                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="12" class="text-center">No project found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo $reports->links(); ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('select[name="zone"]').on('change', function() {
                var zone = jQuery(this).val();
                if (zone) {
                    jQuery.ajax({
                        url: '/project/fetchWoredas/' + zone,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="woreda"]').empty();
                            jQuery.each(data, function(key, value) {
                                $('select[name="woreda"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="woreda"]').empty();
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/projects/index.blade.php ENDPATH**/ ?>