<?php $__env->startSection('content'); ?>


    
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="row">

                        <div class="col-lg-12 margin-tb">

                            <div class="pull-left">

                                <h2><?php echo $__env->yieldContent('type'); ?> <?php echo $__env->yieldContent('title'); ?></h2>

                            </div>

                            <div class="pull-right">

                                <a class="btn btn-primary" href="<?php echo $__env->yieldContent('back'); ?>"> Back</a>

                            </div>

                        </div>

                    </div>


                    <?php if(count($errors) > 0): ?>

                    <div class="alert alert-danger">

                        <strong>Whoops!</strong> There were some problems with your input.<br><br>

                        <ul>

                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <li><?php echo e($error); ?></li>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>

                    </div>

                    <?php endif; ?>

                    <div class="card col-sm-8">

                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php echo $__env->yieldContent('form'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/layouts/components/form.blade.php ENDPATH**/ ?>