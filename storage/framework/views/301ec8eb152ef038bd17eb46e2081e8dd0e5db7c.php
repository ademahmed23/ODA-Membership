<?php if($checkbox): ?>
    <?php if($ruleHide): ?>
        <td class="<?php echo e($theme->checkbox->thClass); ?>"
            style="<?php echo e($theme->checkbox->thStyle); ?>">
        </td>
    <?php elseif($ruleDisable): ?>
        <td class="<?php echo e($theme->checkbox->thClass); ?>" style="<?php echo e($theme->thStyle); ?>">
            <div class="<?php echo e($theme->checkbox->divClass); ?>">
                <label class="<?php echo e($theme->checkbox->labelClass); ?>">
                    <input <?php if(isset($ruleSetAttribute['attribute'])): ?>
                           <?php echo e($attributes->merge([$ruleSetAttribute['attribute'] => $ruleSetAttribute['value']])->class($theme->checkbox->inputClass)); ?>

                           <?php else: ?>
                           class="<?php echo e($theme->checkbox->inputClass); ?>"
                           <?php endif; ?>
                           disabled
                           type="checkbox">
                </label>
            </div>
        </td>
    <?php else: ?>
        <td class="<?php echo e($theme->checkbox->thClass); ?>"
            style="<?php echo e($theme->checkbox->thStyle); ?>">
            <div class="<?php echo e($theme->checkbox->divClass); ?>">
                <label class="<?php echo e($theme->checkbox->labelClass); ?>">
                    <input <?php if(isset($ruleSetAttribute['attribute'])): ?>
                           <?php echo e($attributes->merge([$ruleSetAttribute['attribute'] => $ruleSetAttribute['value']])->class($theme->checkbox->inputClass)); ?>

                           <?php else: ?>
                           class="<?php echo e($theme->checkbox->inputClass); ?>"
                           <?php endif; ?>
                           type="checkbox"
                           wire:model.defer="checkboxValues"
                           value="<?php echo e($attribute); ?>">
                </label>
            </div>
        </td>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/vendor/livewire-powergrid/components/checkbox-row.blade.php ENDPATH**/ ?>