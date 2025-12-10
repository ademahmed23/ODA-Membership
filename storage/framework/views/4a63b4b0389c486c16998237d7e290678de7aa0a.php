<?php $__env->startSection('model','Regional'); ?>
<?php $__env->startSection('count',$count); ?>
<?php $__env->startSection('title','Regional'); ?>
<?php $__env->startSection('insert','Regional'); ?>
<?php $__env->startSection('icons','layout'); ?>
<?php $__env->startSection('route',route('regional.create')); ?>
<?php $__env->startSection('import',route('regional.import')); ?>

<?php $__env->startSection('table'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('regional-table', [])->html();
} elseif ($_instance->childHasBeenRendered('oo1sZpG')) {
    $componentId = $_instance->getRenderedChildComponentId('oo1sZpG');
    $componentTag = $_instance->getRenderedChildComponentTagName('oo1sZpG');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('oo1sZpG');
} else {
    $response = \Livewire\Livewire::mount('regional-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('oo1sZpG', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/regional/index.blade.php ENDPATH**/ ?>