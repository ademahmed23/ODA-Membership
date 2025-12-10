  

  <?php $__env->startSection('content'); ?>
      
      
      <div>
          <div class="content">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-lg-3 col-md-6 col-sm-6">
                          <div class="col-lg-12 col-md-12 col-12 mb-4">
                              <div class="card">
                                  <div class="card-body">
                                      <div class="card-title d-flex align-items-start justify-content-between">
                                          <div class="avatar flex-shrink-0">
                                              
                                              <i class="bx bxs-city" style="font-size: 2.5em;color:green;"></i>
                                              
                                          </div>
                                      </div>
                                      <span><?php echo $__env->yieldContent('title'); ?></span>
                                      <h3 class="card-title text-nowrap mb-1"><?php echo e($count); ?></h3>
                                  </div>

                              </div>

                          </div>

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
                                  <h4 class="card-title "><?php echo $__env->yieldContent('title'); ?></h4>
                              </div>





                              <div class="card-body">

                                  <div class="row">

                                      <div class="col-3 mb-3 align-content-end" style="text-align: right;">
                                          <form action="<?php echo $__env->yieldContent('import'); ?>" method="POST" enctype="multipart/form-data">
                                              <?php echo csrf_field(); ?>
                                              <input type="file" name="file" class="form-control">
                                              <button class="btn btn-sm btn-success" style="text-align: right;">Import
                                                  <?php echo $__env->yieldContent('insert'); ?></button>
                                          </form>
                                      </div>


                                      
                                      <div class="col-3 mb-3 align-content-center" style="text-align: right;">
                                          <a href="<?php echo $__env->yieldContent('route'); ?>" class="btn btn-sm btn-success">Add
                                              <?php echo $__env->yieldContent('insert'); ?></a>
                                      </div>
                                  </div>

                                  <div class="table-responsive table-strip">
                                      
                                      <?php echo $__env->yieldContent('table'); ?>
                                  </div>
    

                              </div>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
      </div>
      
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/layouts/components/index2.blade.php ENDPATH**/ ?>