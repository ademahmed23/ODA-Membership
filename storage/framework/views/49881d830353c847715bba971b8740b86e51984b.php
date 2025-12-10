<div>
    <?php if ($__env->exists(data_get($setUp, 'footer.includeViewOnTop'))) echo $__env->make(data_get($setUp, 'footer.includeViewOnTop'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(!is_array($data) && count(data_get($setUp, 'footer.perPageValues')) > 1): ?>
        <footer class="mt-50 pb-1 w-100 align-items-end px-1 d-flex flex-wrap justify-content-sm-center justify-content-md-between">
            <div class="col-auto overflow-auto my-sm-2 my-md-0 ms-sm-0">
                <?php if(data_get($setUp, 'footer.perPage') && count(data_get($setUp, 'footer.perPageValues')) > 1): ?>
                    <div class="d-flex flex-lg-row align-items-center">
                        <label class="w-auto">
                            <select wire:model.lazy="setUp.footer.perPage" class="form-select">
                                <?php $__currentLoopData = data_get($setUp, 'footer.perPageValues'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>">
                                        <?php if($value == 0): ?>
                                            <?php echo e(trans('livewire-powergrid::datatable.labels.all')); ?>

                                        <?php else: ?> <?php echo e($value); ?>

                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <small class="ms-2 text-muted">
                            <?php echo e(trans('livewire-powergrid::datatable.labels.results_per_page')); ?>

                        </small>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-auto overflow-auto mt-2 mt-sm-0">
                <?php if(method_exists($data, 'links')): ?>
                    <?php echo $data->links(data_get($setUp, 'footer.pagination') ?: powerGridThemeRoot().'.pagination', [
                        'recordCount' => data_get($setUp, 'footer.recordCount')
                        ]); ?>

                <?php endif; ?>
            </div>
        </footer>
    <?php endif; ?>
    <?php if ($__env->exists(data_get($setUp, 'footer.includeViewOnBottom'))) echo $__env->make(data_get($setUp, 'footer.includeViewOnBottom'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/vendor/livewire-powergrid/components/frameworks/bootstrap5/footer.blade.php ENDPATH**/ ?>