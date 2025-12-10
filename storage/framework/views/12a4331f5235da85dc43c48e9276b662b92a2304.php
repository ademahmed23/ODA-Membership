

<?php $__env->startSection('model','Arsii Lixaa'); ?>
<?php $__env->startSection('count',$count); ?>
<?php $__env->startSection('title','Arsii Lixaa'); ?>
<?php $__env->startSection('insert','Arsii Lixaa'); ?>
<?php $__env->startSection('icons','layout'); ?>
<?php $__env->startSection('route',route('arsii_lixaa.create')); ?>
<?php $__env->startSection('import',route('arsii_lixaa.import')); ?>
<?php $__env->startSection('filterAction', route('arsii_lixaa.index')); ?>
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
            <th>#</th>
            <th>Member ID</th>
            <th>Organization Name</th>
            <th>Organization Type</th>
            <th>Woreda</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Payment Period</th>
            <th>Member Started</th>
            <th>Payment Amount</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($report->id); ?></td>
            <td><?php echo e($report->member_id); ?></td>
            <td><?php echo e($report->organization_name); ?></td>
            <td><?php echo e($report->organization_type); ?></td>
            <td><?php echo e($report->woreda); ?></td>
            <td><?php echo e($report->phone_number); ?></td>
            <td><?php echo e($report->email); ?></td>
            <td><?php echo e($report->payment_period); ?></td>
            <td><?php echo e($report->member_started); ?></td>
            <td><?php echo e($report->payment); ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="actionDropdown<?php echo e($report->id); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="actionDropdown<?php echo e($report->id); ?>">
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('arsii_lixaa-edit')): ?>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('arsii_lixaa.edit', $report->id)); ?>">Edit</a>
                        </li>
                        <?php endif; ?>

                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('arsii_lixaa-delete')): ?>
                        <li>
                            <form action="<?php echo e(route('arsii_lixaa.destroy', $report->id)); ?>" method="POST" onsubmit="return confirm('Are you sure?');">
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
                                <a class="dropdown-item text-warning" href="<?php echo e(route('arsii_lixaa.pay', $report->id)); ?>">Pay</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>


<p class="text-muted">Select a woreda to see members.</p>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/organization/arsii_lixaa/index.blade.php ENDPATH**/ ?>