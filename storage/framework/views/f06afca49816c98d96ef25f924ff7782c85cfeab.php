<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'column' => null,
    'theme' => null,
    'sortField' => null,
    'sortDirection' => null,
    'enabledFilters' => null,
    'actions' => null,
    'dataField' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'column' => null,
    'theme' => null,
    'sortField' => null,
    'sortDirection' => null,
    'enabledFilters' => null,
    'actions' => null,
    'dataField' => null,
]); ?>
<?php foreach (array_filter(([
    'column' => null,
    'theme' => null,
    'sortField' => null,
    'sortDirection' => null,
    'enabledFilters' => null,
    'actions' => null,
    'dataField' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
    if (filled($column->dataField)) {
        $field = $column->dataField;
    } else {
        $field = $column->field;
    }
?>
<th class="<?php echo e($theme->table->thClass .' '. $column->headerClass); ?>"
    wire:key="<?php echo e(md5($column->field)); ?>"
    style="<?php echo e($column->hidden === true ? 'display:none': ''); ?>; width: max-content; <?php if($column->sortable): ?> cursor:pointer; <?php endif; ?> <?php echo e($theme->table->thStyle.' '. $column->headerStyle); ?>">
    <div class="<?php echo e($theme->cols->divClass); ?>"
        <?php if($column->sortable === true): ?> wire:click="sortBy('<?php echo e($field); ?>')" <?php endif; ?>>
        <?php if($column->sortable === true): ?>
            <span class="text-md pr-2">
				<?php if($sortField !== $field): ?>
                    &#8597;
                <?php elseif($sortDirection == 'desc'): ?>
                    &#8593;
                <?php else: ?>
                    &#8595;
                <?php endif; ?>
					</span>
        <?php endif; ?>
        <span><?php echo $column->title; ?></span>
    </div>
</th>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/vendor/livewire-powergrid/components/cols.blade.php ENDPATH**/ ?>