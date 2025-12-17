<?php $__env->startSection('model', 'Baalee'); ?>
<?php $__env->startSection('count', $count); ?>
<?php $__env->startSection('title', 'Baalee'); ?>
<?php $__env->startSection('insert', 'Baalee'); ?>
<?php $__env->startSection('icons', 'layout'); ?>
<?php $__env->startSection('route', route('zone3.create')); ?>
<?php $__env->startSection('import', route('zone3.import')); ?>
<?php $__env->startSection('filterAction', route('zone3.index')); ?>
<?php $__env->startSection('filterName', 'woreda'); ?>
<?php $__env->startSection('filterLabel', 'Woreda'); ?>
<?php $__env->startSection('filterButton', 'Show Data'); ?>
<?php $__env->startSection('exportEnabled', true); ?>
<?php $__env->startSection('exportRoute', url('zoneMember-export/' . $zone . '/' . $woreda)); ?>
<?php $__env->startSection('exportText', 'Download'); ?>


    <?php $__env->startSection('table'); ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    
                    <th>id</th>
                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Woreda</th>

                    <th>Gender</th>
                    <th>Age</th>
                    <th>Education</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Membership Type</th>
                    <th>Membership Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        
                        <td><?php echo e($report->id); ?></td>
                        <td><?php echo e($report->member_id); ?></td>
                        <td><?php echo e($report->first_name); ?></td>
                        <td><?php echo e($report->middle_name); ?></td>
                        <td><?php echo e($report->last_name); ?></td>
                        <td><?php echo e($report->woreda); ?></td>
                        <td><?php echo e($report->gender); ?></td>
                        <td><?php echo e($report->age); ?></td>
                        <td><?php echo e($report->education_level); ?></td>
                        <td><?php echo e($report->address); ?></td>
                        <td><?php echo e($report->contact_number); ?></td>
                        <td><?php echo e($report->email); ?></td>
                        <td><?php echo e($report->position); ?></td>
                        <td><?php echo e($report->membership_type); ?></td>
                        <td><?php echo e($report->membership_fee); ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                    id="actionDropdown<?php echo e($report->id); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo e($report->id); ?>">
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone1-edit')): ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('zone1.edit', $report->id)); ?>">Edit</a>
                                        </li>
                                    <?php endif; ?>

                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone1-delete')): ?>
                                        <li>
                                            <form action="<?php echo e(route('zone1.destroy', $report->id)); ?>" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                                            </form>
                                        </li>
                                    <?php endif; ?>

                                    
                                    <li>
                                        <?php if($report->has_paid): ?>
                                            <span class="dropdown-item text-success">Paid</span>
                                        <?php else: ?>
                                            <a class="dropdown-item text-warning"
                                                href="<?php echo e(route('zone1.pay', $report->id)); ?>">Pay</a>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/zones/zone3/index.blade.php ENDPATH**/ ?>