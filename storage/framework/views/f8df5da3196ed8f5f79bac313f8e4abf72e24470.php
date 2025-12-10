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
} elseif ($_instance->childHasBeenRendered('3QlN4QD')) {
    $componentId = $_instance->getRenderedChildComponentId('3QlN4QD');
    $componentTag = $_instance->getRenderedChildComponentTagName('3QlN4QD');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('3QlN4QD');
} else {
    $response = \Livewire\Livewire::mount('abroad-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('3QlN4QD', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/abroad/index.blade.php ENDPATH**/ ?>