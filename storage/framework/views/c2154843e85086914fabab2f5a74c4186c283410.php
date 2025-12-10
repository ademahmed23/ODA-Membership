<?php if(data_get($setUp, 'header.showMessageSoftDeletes') && ($softDeletes === 'withTrashed' || $softDeletes === 'onlyTrashed')): ?>
    <div class="alert alert-warning my-1" role="alert">
        <?php if($softDeletes === 'withTrashed'): ?>
            <?php echo app('translator')->get('livewire-powergrid::datatable.soft_deletes.message_with_trashed'); ?>
        <?php else: ?>
            <?php echo app('translator')->get('livewire-powergrid::datatable.soft_deletes.message_only_trashed'); ?>
        <?php endif; ?>
    </div>
<?php endif; ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/vendor/livewire-powergrid/components/frameworks/bootstrap5/header/message-soft-deletes.blade.php ENDPATH**/ ?>