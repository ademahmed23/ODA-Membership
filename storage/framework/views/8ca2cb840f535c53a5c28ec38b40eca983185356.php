<?php if(count($enabledFilters)): ?>
    <div class="col-md-12 d-flex" style="margin-top: 5px">
        <?php if(count($enabledFilters) > 1): ?>
            <div wire:click.prevent="clearAllFilters()"
                 style="cursor: pointer; padding-right: 4px">
            <span class="badge rounded-pill bg-secondary"><?php echo e(trans('livewire-powergrid::datatable.buttons.clear_all_filters')); ?>

                 <svg width="10" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                    <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"/>
                </svg>
            </span>
            </div>
        <?php endif; ?>
        <?php $__currentLoopData = $enabledFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div wire:click.prevent="clearFilter('<?php echo e($field); ?>')"
                 style="cursor: pointer; padding-right: 4px">
            <span class="badge rounded-pill bg-light text-dark"><?php echo e($filter['label']); ?>

                 <svg width="10" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                    <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"/>
                </svg>
            </span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/vendor/livewire-powergrid/components/frameworks/bootstrap5/header/enabled-filters.blade.php ENDPATH**/ ?>