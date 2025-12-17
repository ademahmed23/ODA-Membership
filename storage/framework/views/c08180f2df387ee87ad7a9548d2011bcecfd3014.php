<?php $__env->startSection('content'); ?>



<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">


                    
            
</div>
<?php if(session()->has('success')): ?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="bx bxs-x" style="font-size: 2em;color:green;"></i>
    </button>
    <span>
        <b> </b> <?php echo e(session('success')); ?> </span>

</div>
<?php endif; ?>

<?php if(session()->has('delete')): ?>
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="bx bxs-x" style="font-size: 2em;color:red;"></i>
    </button>
    <span>
        <?php echo e(session('delete')); ?></span>

</div>
<?php endif; ?>
<?php if(session()->has('update')): ?>
<div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="bx bxs-x" style="font-size: 2em;color:orange;"></i>
    </button>
    <span>
        <?php echo e(session('update')); ?></span>

</div>
<?php endif; ?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <?php if($model != null): ?>
            <h4 class="card-title "><?php echo e($model); ?> Member Report</h4>
            <?php else: ?>
            <h4 class="card-title ">Member Report</h4>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-6 mb-3">

                    <form action="zoneMember-pay" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                        <?php echo csrf_field(); ?>
                        <label for="zone" style="margin-right: 10px;">Zone</label>
                        <select name="model" id="model" class="form-control dynamic" data-dependent="woreda" style="display: inline-block;width:35%;margin-right:10px;">

                            <option value="">Select Zone</option>
                            <option value="zone1">Arsii</option>
                            <option value="zone2">Arsii-Lixaa</option>
                            <option value="zone3">Baalee</option>
                            <option value="zone4">Baalee-Bahaa</option>
                            <option value="zone5">Booranaa</option>
                            <option value="zone6">Bunno- Baddalle</option>
                            <option value="zone7">Finfinnee</option>
                            <option value="zone8">Gujii</option>
                            <option value="zone9">Gujii-Lixaa</option>
                            <option value="zone10">Harargee-Bahaa</option>
                            <option value="zone11">Harargee-Lixaa</option>
                            <option value="zone12">Horroo-Guduruu-Wallaga</option>
                            <option value="zone13">Iluu-Abbaa-Booraa</option>
                            <option value="zone14">Jimmaa</option>
                            <option value="zone15">Qeellam-Wallaga</option>
                            <option value="zone16">Shawaa-Bahaa</option>
                            <option value="zone17">Shawaa-Kaabaa</option>
                            <option value="zone18">Shawaa-Kibbaaa-Lixaa</option>
                            <option value="zone19">Shawaa-Lixaa</option>
                            <option value="zone20">Wallaga-Bahaa</option>
                            <option value="zone21">Wallaga-Lixaa</option>
                        </select>
                        <label for="woreda" style="margin-right: 10px;">Woreda</label>
                        <select name="woreda" id="woreda" class="form-control" style="display: inline-block;width:35%;margin-right:10px;">
                            <option value="">Select Woreda</option>
                        </select>
                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                    </form>


                    
                </div>

                



        </div>
        <div class="table-responsive">
            
            <table class="table table-striped table-sortable pb-1 mt-2">

                <thead>

                    <tr>
                        <th>Name </th>
                        <th>Zone</th>
                        <th>Woreda</th>
                        <th>Position</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                </thead>
                <tbody>
                    
                    <?php if($pays != null): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $pays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="border py-2"><?php echo e($pay->name); ?></td>
                        <td class="border py-2"><?php echo e($pay->model); ?></td>
                        <td class="border py-2"><?php echo e($pay->woreda); ?></td>
                        <td class="border py-2"><?php echo e($pay->position); ?></td>
                        <td class="border py-2"><?php echo e($pay->amount); ?></td>
                        <td class="border py-2"><?php echo e($pay->date); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center">No Data Found</td>
                    </tr>
                    <?php endif; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No Data Found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('select[name="model"]').on('change', function() {
            console.log('change');
            var zone = jQuery(this).val();
            console.log(zone);
            if (zone) {
                jQuery.ajax({
                    url: 'fetchWoreda/' + zone
                    , type: "GET"
                    , dataType: "json"
                    , success: function(data) {
                        console.log(data);
                        jQuery('select[name="woreda"]').empty();
                        jQuery.each(data, function(key, value) {
                            $('select[name="woreda"]').append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="woreda"]').empty();
            }
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/zoneMemberPay/index.blade.php ENDPATH**/ ?>