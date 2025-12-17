<?php $__env->startSection('model','Honorable'); ?>
<?php $__env->startSection('title','Honorable'); ?>
<?php $__env->startSection('back',route('honorable.index')); ?>
<?php $__env->startSection('type','Edit'); ?>

<?php $__env->startSection('form'); ?>

<form method="POST" action="<?php echo e(route('honorable.update',$honorable->id)); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>First Name</strong>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Name" value="<?php echo e($honorable->first_name); ?>">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Middle Name</strong>
            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="<?php echo e($honorable->middle_name); ?>">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Last Name</strong>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="<?php echo e($honorable->last_name); ?>">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Sex</strong>
            <select class="form-control" id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Age</strong>
            <input type="number" class="form-control" id="age" name="age" placeholder="Enter Age" value="<?php echo e($honorable->age); ?>">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Contact Number</strong>
            <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Enter Contact Number" value="<?php echo e($honorable->contact_number); ?>">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Address/Workplace</strong>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="<?php echo e($honorable->address); ?>">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Occupation</strong>
            <input type="text" class="form-control" id="position" name="position" placeholder="Enter Position" value="<?php echo e($honorable->position); ?>">
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>MemberShip Fee</strong>
            <input type="number" class="form-control" id="membership_fee" name="membership_fee" placeholder="Enter MemberShip Fee" value="<?php echo e($honorable->membership_fee); ?>">
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/honorable/edit.blade.php ENDPATH**/ ?>