<?php $__env->startSection('model','Honorable'); ?>
<?php $__env->startSection('count',$count); ?>
<?php $__env->startSection('title','Honorable'); ?>
<?php $__env->startSection('insert','Honorable'); ?>
<?php $__env->startSection('icons','medal'); ?>
<?php $__env->startSection('route',route('honorable.create')); ?>
<?php $__env->startSection('import',route('honorable.import')); ?>

<?php $__env->startSection('table'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('honorable-table', [])->html();
} elseif ($_instance->childHasBeenRendered('cvQrnSf')) {
    $componentId = $_instance->getRenderedChildComponentId('cvQrnSf');
    $componentTag = $_instance->getRenderedChildComponentTagName('cvQrnSf');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('cvQrnSf');
} else {
    $response = \Livewire\Livewire::mount('honorable-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('cvQrnSf', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/honorable/index.blade.php ENDPATH**/ ?>