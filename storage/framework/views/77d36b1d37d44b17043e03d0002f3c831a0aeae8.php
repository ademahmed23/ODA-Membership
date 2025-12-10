<?php $__env->startSection('model','B-M-Finfinnee'); ?>
<?php $__env->startSection('count',$count); ?>
<?php $__env->startSection('title','B-M-Finfinnee'); ?>
<?php $__env->startSection('insert','B-M-Finfinnee'); ?>
<?php $__env->startSection('icons','layout'); ?>
<?php $__env->startSection('route',route('city8.create')); ?>
<?php $__env->startSection('import',route('city8.import')); ?>

<?php $__env->startSection('table'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('city8-table', [])->html();
} elseif ($_instance->childHasBeenRendered('KWbGHoP')) {
    $componentId = $_instance->getRenderedChildComponentId('KWbGHoP');
    $componentTag = $_instance->getRenderedChildComponentTagName('KWbGHoP');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('KWbGHoP');
} else {
    $response = \Livewire\Livewire::mount('city8-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('KWbGHoP', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/cities/city8/index.blade.php ENDPATH**/ ?>