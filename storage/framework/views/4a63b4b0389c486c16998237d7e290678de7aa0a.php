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
} elseif ($_instance->childHasBeenRendered('pV27erN')) {
    $componentId = $_instance->getRenderedChildComponentId('pV27erN');
    $componentTag = $_instance->getRenderedChildComponentTagName('pV27erN');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('pV27erN');
} else {
    $response = \Livewire\Livewire::mount('regional-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('pV27erN', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/regional/index.blade.php ENDPATH**/ ?>