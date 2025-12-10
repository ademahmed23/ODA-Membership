<div>
    <?php if ($__env->exists(data_get($setUp, 'header.includeViewOnTop'))) echo $__env->make(data_get($setUp, 'header.includeViewOnTop'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="dt--top-section">
        <div class="row">
            <div class="col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center">
                <?php echo $__env->make(powerGridThemeRoot().'.header.actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="me-1">
                    <?php echo $__env->renderWhen(data_get($setUp, 'exportable'), powerGridThemeRoot().'.header.export', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
                </div>

                <?php echo $__env->make(powerGridThemeRoot().'.header.toggle-columns', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php if ($__env->exists(powerGridThemeRoot().'.header.soft-deletes')) echo $__env->make(powerGridThemeRoot().'.header.soft-deletes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make(powerGridThemeRoot().'.header.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3">
                <?php echo $__env->make(powerGridThemeRoot().'.header.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
    <?php echo $__env->make(powerGridThemeRoot().'.header.batch-exporting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make(powerGridThemeRoot().'.header.enabled-filters', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if ($__env->exists(data_get($setUp, 'header.includeViewOnBottom'))) echo $__env->make(data_get($setUp, 'header.includeViewOnBottom'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if ($__env->exists(powerGridThemeRoot().'.header.message-soft-deletes')) echo $__env->make(powerGridThemeRoot().'.header.message-soft-deletes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/vendor/livewire-powergrid/components/frameworks/bootstrap5/header.blade.php ENDPATH**/ ?>