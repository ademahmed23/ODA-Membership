<?php if($queues && $showExporting): ?>

    <?php if($batchExporting && !$batchFinished): ?>
        <div wire:poll="updateExportProgress"
             class="my-3 px-4 rounded-md py-3 shadow-sm text-center">
            <div><?php echo e(trans('livewire-powergrid::datatable.export.exporting')); ?></div>
            <div
                class="bg-emerald-500 rounded text-center"
                style="background-color: rgb(16 185 129); height: 0.25rem; width: <?php echo e($batchProgress); ?>%; transition: width 300ms;">
            </div>
        </div>

        <div wire:poll="updateExportProgress"
             class="my-3 px-4 rounded-md py-3 shadow-sm text-center">
            <div><?php echo e($batchProgress); ?>%</div>
            <div><?php echo e(trans('livewire-powergrid::datatable.export.exporting')); ?></div>
        </div>
    <?php endif; ?>

    <?php if($batchFinished): ?>
        <div class="my-3">
            <p>
                <button class="btn btn-primary"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseCompleted"
                        aria-expanded="false"
                        aria-controls="collapseCompleted">
                    ⚡ <?php echo e(trans('livewire-powergrid::datatable.export.completed')); ?>

                </button>
            </p>
            <div class="collapse" id="collapseCompleted">
                <div class="card card-body">
                    <?php $__currentLoopData = $exportedFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex w-full p-2" style="cursor:pointer">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'livewire-powergrid::components.icons.download','data' => ['style' => 'width: 1.5rem;
                                           margin-right: 6px;
                                           color: #2d3034;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('livewire-powergrid::icons.download'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 1.5rem;
                                           margin-right: 6px;
                                           color: #2d3034;']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <a
                                wire:click="downloadExport('<?php echo e($file); ?>')">
                                <?php echo e($file); ?>

                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/vendor/livewire-powergrid/components/frameworks/bootstrap5/header/batch-exporting.blade.php ENDPATH**/ ?>