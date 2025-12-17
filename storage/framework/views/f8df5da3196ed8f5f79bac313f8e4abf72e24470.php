<?php $__env->startSection('model','Abroad'); ?>
<?php $__env->startSection('count',$count); ?>
<?php $__env->startSection('title','Abroad'); ?>
<?php $__env->startSection('insert','Abroad'); ?>
<?php $__env->startSection('icons','layout'); ?>
<?php $__env->startSection('route',route('abroad.create')); ?>
<?php $__env->startSection('import',route('abroad.import')); ?>

<?php $__env->startSection('table'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('abroad-table', [])->html();
} elseif ($_instance->childHasBeenRendered('7Khcs3j')) {
    $componentId = $_instance->getRenderedChildComponentId('7Khcs3j');
    $componentTag = $_instance->getRenderedChildComponentTagName('7Khcs3j');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('7Khcs3j');
} else {
    $response = \Livewire\Livewire::mount('abroad-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('7Khcs3j', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/abroad/index.blade.php ENDPATH**/ ?>