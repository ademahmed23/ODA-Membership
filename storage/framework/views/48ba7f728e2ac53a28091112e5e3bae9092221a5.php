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
                                <h4 class="card-title "><?php echo e($name); ?> Member Report</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <form action="zoneMember-report" method="POST" enctype="multipart/form-data"
                                            style="display: flex; align-items: center;">
                                            <?php echo csrf_field(); ?>
                                            <label for="zone" style="margin-right: 10px;">Zone</label>
                                            <select name="zone" id="zone" class="form-control dynamic"
                                                data-dependent="woreda"
                                                style="display: inline-block;width:35%;margin-right:10px;">
                                                <option value="">Select Zone</option>
                                                <option value="zone1s">Arsii</option>
                                                <option value="zone2s">Arsii-Lixaa</option>
                                                <option value="zone3s">Baalee</option>
                                                <option value="zone4s">Baalee-Bahaa</option>
                                                <option value="zone5s">Booranaa</option>
                                                <option value="zone6s">Bunno- Baddalle</option>
                                                <option value="zone7s">Finfinnee</option>
                                                <option value="zone8s">Gujii</option>
                                                <option value="zone9s">Gujii-Lixaa</option>
                                                <option value="zone10s">Harargee-Bahaa</option>
                                                <option value="zone11s">Harargee-Lixaa</option>
                                                <option value="zone12s">Horroo-Guduruu-Wallaga</option>
                                                <option value="zone13s">Iluu-Abbaa-Booraa</option>
                                                <option value="zone14s">Jimmaa</option>
                                                <option value="zone15s">Qeellam-Wallaga</option>
                                                <option value="zone16s">Shawaa-Bahaa</option>
                                                <option value="zone17s">Shawaa-Kaabaa</option>
                                                <option value="zone18s">Shawaa-Kibbaaa-Lixaa</option>
                                                <option value="zone19s">Shawaa-Lixaa</option>
                                                <option value="zone20s">Wallaga-Bahaa</option>
                                                <option value="zone21s">Wallaga-Lixaa</option>
                                            </select>
                                            <label for="woreda" style="margin-right: 10px;">Woreda</label>
                                            <select name="woreda" id="woreda" class="form-control"
                                                style="display: inline-block;width:35%;margin-right:10px;">
                                                <option value="">Select Woreda</option>
                                            </select>

                                            <button class="btn btn-sm btn-success"
                                                style="display: inline-block;">Fetch</button>
                                        </form>


                                        
                                    </div>
                                    <?php if($export == true): ?>
                                        <div class="col-6 mb-3 align-content-end" style="text-align: right;">
                                            <a href="zoneMember-export/<?php echo e($zone); ?>/<?php echo e($woreda); ?>"
                                                class="btn btn-sm btn-success">Download</a>
                                        </div>
                                    <?php endif; ?>


                                </div>
                                <div class="table-responsive">
                                    
                                    <table class="table table-striped table-sortable pb-1 mt-2">

                                        <thead>

                                            <tr>
                                                <th>Number </th>
                                                
                                                <th>Zone</th>
                                                <th>Woreda</th>
                                                <th>Position</th>
                                                <th>Total</th>
                                                </th>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="border py-2"><?php echo e($report->id); ?></td>
                                                    
                                                    <td class="border py-2"><?php echo e($report->zone); ?></td>
                                                    <td class="border py-2"><?php echo e($report->woreda); ?></td>
                                                    <td class="border py-2"><?php echo e($report->position); ?></td>
                                                    <td class="border py-2"><?php echo e($report->total); ?></td>

                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>

                                </div>
                                <?php echo $reports->links(); ?>


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
            jQuery('select[name="zone"]').on('change', function() {
                console.log('change');
                var zone = jQuery(this).val();
                console.log(zone);
                if (zone) {
                    jQuery.ajax({
                        url: 'fetchZone/' + zone,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            jQuery('select[name="woreda"]').empty();
                            jQuery.each(data, function(key, value) {
                                $('select[name="woreda"]').append('<option value="' +
                                    value + '">' + value + '</option>');
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/report/zoneMember.blade.php ENDPATH**/ ?>