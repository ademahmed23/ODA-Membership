<?php $__env->startSection('model','Announcement'); ?>
<?php $__env->startSection('count',$count); ?>
<?php $__env->startSection('title','Announcement'); ?>
<?php $__env->startSection('insert','Announcement'); ?>
<?php $__env->startSection('icons','microphone'); ?>
<?php $__env->startSection('route',route('announcement.create')); ?>
<?php $__env->startSection('import',route('city1.import')); ?>

<?php $__env->startSection('table'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('announcement-table', [])->html();
} elseif ($_instance->childHasBeenRendered('JGYNWHJ')) {
    $componentId = $_instance->getRenderedChildComponentId('JGYNWHJ');
    $componentTag = $_instance->getRenderedChildComponentTagName('JGYNWHJ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('JGYNWHJ');
} else {
    $response = \Livewire\Livewire::mount('announcement-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('JGYNWHJ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.components.index2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/announcement/index.blade.php ENDPATH**/ ?>