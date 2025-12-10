<div class="btn-group">
    <button class="btn btn-secondary btn-sm dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">
                    <span>
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </span>
    </button>
    <ul class="dropdown-menu">
        <?php if(in_array('excel', data_get($setUp, 'exportable.type'))): ?>
            <li class="d-flex">
                <div class="dropdown-item">
                    <?php echo app('translator')->get('Excel'); ?>
                    <a class="text-black-50" wire:click="exportToXLS()" href="#">
                        <?php echo app('translator')->get('livewire-powergrid::datatable.labels.all'); ?>
                    </a>
                    <?php if($checkbox): ?>
                        /
                        <a class="text-black-50" wire:click="exportToXLS(true)" href="#">
                            <?php echo app('translator')->get('livewire-powergrid::datatable.labels.selected'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </li>
        <?php endif; ?>
        <?php if(in_array('csv', data_get($setUp, 'exportable.type'))): ?>
            <li class="d-flex">
                <div class="dropdown-item">
                    <?php echo app('translator')->get('Csv'); ?>
                    <a class="text-black-50" wire:click="exportToCsv" href="#">
                        <?php echo app('translator')->get('livewire-powergrid::datatable.labels.all'); ?>
                    </a>
                    <?php if($checkbox): ?>
                        /
                        <a class="text-black-50" wire:click="exportToCsv(true)" href="#">
                            <?php echo app('translator')->get('livewire-powergrid::datatable.labels.selected'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</div>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/vendor/livewire-powergrid/components/frameworks/bootstrap5/header/export.blade.php ENDPATH**/ ?>