<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'makeFilters' => null,
    'checkbox' => null,
    'columns' => null,
    'actions' => null,
    'theme' => null,
    'enabledFilters' => null,
    'inputTextOptions' => [],
    'tableName' => null,
    'filters' => [],
    'setUp' => null
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'makeFilters' => null,
    'checkbox' => null,
    'columns' => null,
    'actions' => null,
    'theme' => null,
    'enabledFilters' => null,
    'inputTextOptions' => [],
    'tableName' => null,
    'filters' => [],
    'setUp' => null
]); ?>
<?php foreach (array_filter(([
    'makeFilters' => null,
    'checkbox' => null,
    'columns' => null,
    'actions' => null,
    'theme' => null,
    'enabledFilters' => null,
    'inputTextOptions' => [],
    'tableName' => null,
    'filters' => [],
    'setUp' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div>
    <?php if(config('livewire-powergrid.filter') === 'inline'): ?>
        <tr class="<?php echo e($theme->table->trClass); ?> <?php echo e($theme->table->trFiltersClass); ?>"
            style="<?php echo e($theme->table->trStyle); ?> <?php echo e($theme->table->trFiltersStyle); ?>">
            <?php if(count($makeFilters)): ?>
                <?php if(data_get($setUp, 'detail.showCollapseIcon')): ?>
                    <td class="<?php echo e($theme->table->tdBodyClass); ?>" style="<?php echo e($theme->table->tdBodyStyle); ?>"></td>
                <?php endif; ?>
                <?php if($checkbox): ?>
                    <td class="<?php echo e($theme->table->tdBodyClass); ?>" style="<?php echo e($theme->table->tdBodyStyle); ?>"></td>
                <?php endif; ?>
                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="<?php echo e($theme->table->tdBodyClass); ?>"
                        style="<?php echo e($column->hidden === true ? 'display:none': ''); ?>; <?php echo e($theme->table->tdBodyStyle); ?>">
                        <?php $__currentLoopData = data_get($makeFilters, 'date_picker', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($date, 'field') === $column->field): ?>
                                <?php if ($__env->exists($theme->filterDatePicker->view, [
                                     'inline'    => true,
                                     'date'      => $date,
                                     'tableName' => $tableName,
                                     'classAttr' => 'w-full',
                                     'theme'     => $theme->filterDatePicker,
                                ])) echo $__env->make($theme->filterDatePicker->view, [
                                     'inline'    => true,
                                     'date'      => $date,
                                     'tableName' => $tableName,
                                     'classAttr' => 'w-full',
                                     'theme'     => $theme->filterDatePicker,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = data_get($makeFilters, 'select', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $select): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($select, 'field') === $column->field): ?>
                                <?php if ($__env->exists($theme->filterSelect->view, [
                                    'inline' => true,
                                    'column' => $column,
                                    'select' =>$select,
                                    'theme' => $theme->filterSelect,
                                ])) echo $__env->make($theme->filterSelect->view, [
                                    'inline' => true,
                                    'column' => $column,
                                    'select' =>$select,
                                    'theme' => $theme->filterSelect,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = data_get($makeFilters, 'multi_select', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $multiSelect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($multiSelect, 'field') === $column->field): ?>
                                <?php if ($__env->exists($theme->filterMultiSelect->view, [
                                    'inline'    => true,
                                    'column'    => $column,
                                    'selected'  => $filters['multi_select'] ?? [],
                                    'tableName' => $tableName,
                                    'theme'     => $theme->filterMultiSelect,
                                ])) echo $__env->make($theme->filterMultiSelect->view, [
                                    'inline'    => true,
                                    'column'    => $column,
                                    'selected'  => $filters['multi_select'] ?? [],
                                    'tableName' => $tableName,
                                    'theme'     => $theme->filterMultiSelect,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = data_get($makeFilters, 'number', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($number, 'field') === $column->field): ?>
                                <?php if ($__env->exists($theme->filterNumber->view, [
                                     'inline' => true,
                                     'column' => $column,
                                     'number' => $number,
                                     'theme'  => $theme->filterNumber,
                                ])) echo $__env->make($theme->filterNumber->view, [
                                     'inline' => true,
                                     'column' => $column,
                                     'number' => $number,
                                     'theme'  => $theme->filterNumber,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = data_get($makeFilters, 'input_text', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inputText): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($inputText, 'field') === $column->field): ?>
                                <?php if ($__env->exists($theme->filterInputText->view, [
                                     'inline'           => true,
                                     'enabledFilters'   => $enabledFilters,
                                     'inputTextOptions' => $inputTextOptions,
                                     'enabledFilters'   => $enabledFilters,
                                     'theme'            => $theme->filterInputText,
                                ])) echo $__env->make($theme->filterInputText->view, [
                                     'inline'           => true,
                                     'enabledFilters'   => $enabledFilters,
                                     'inputTextOptions' => $inputTextOptions,
                                     'enabledFilters'   => $enabledFilters,
                                     'theme'            => $theme->filterInputText,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = data_get($makeFilters, 'boolean', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booleanFilter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($booleanFilter, 'field') === $column->field): ?>
                                <?php if ($__env->exists($theme->filterBoolean->view, [
                                    'inline'         => true,
                                    'booleanFilter'  => $booleanFilter,
                                    'tableName'      => $tableName,
                                    'theme'          => $theme->filterBoolean,
                               ])) echo $__env->make($theme->filterBoolean->view, [
                                    'inline'         => true,
                                    'booleanFilter'  => $booleanFilter,
                                    'tableName'      => $tableName,
                                    'theme'          => $theme->filterBoolean,
                               ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($actions) && count($actions)): ?>
                    <td colspan="<?php echo e(count($actions)); ?>"></td>
                <?php endif; ?>
            <?php endif; ?>
        </tr>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/vendor/livewire-powergrid/components/inline-filters.blade.php ENDPATH**/ ?>