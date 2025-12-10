<?php $__env->startSection('model','B-M-Baatuu'); ?>
<?php $__env->startSection('count',$count); ?>
<?php $__env->startSection('title','B-M-Baatuu'); ?>
<?php $__env->startSection('insert','B-M-Baatuu'); ?>
<?php $__env->startSection('icons','layout'); ?>
<?php $__env->startSection('route',route('city4.create')); ?>
<?php $__env->startSection('import',route('city4.import')); ?>

<?php $__env->startSection('table'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('city4-table', [])->html();
} elseif ($_instance->childHasBeenRendered('Q9q7m67')) {
    $componentId = $_instance->getRenderedChildComponentId('Q9q7m67');
    $componentTag = $_instance->getRenderedChildComponentTagName('Q9q7m67');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Q9q7m67');
} else {
    $response = \Livewire\Livewire::mount('city4-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('Q9q7m67', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/cities/city4/index.blade.php ENDPATH**/ ?>