 <?php if (isset($component)) { $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015 = $component; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     
     <div class="container" style="height: auto; margin-top:4%;">
         <div class="row align-items-center">
             <div class="col-md-9 ml-auto mr-auto mb-3 text-center">
                 
             </div>
             <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">

                 <?php if(session('status')): ?>
                     <div class="mb-4 font-medium text-sm text-green-600">
                         <?php echo e(session('status')); ?>

                     </div>
                 <?php endif; ?>

                 <form class="form" method="POST" action="<?php echo e(route('login')); ?>">
                     <?php echo csrf_field(); ?>

                     <div class="card card-login card-hidden mb-3">
                         <div class="card-header card-header-success text-center">
                             <h4 class="card-title"><strong><?php echo e(__('ORMOIA DEVELOPMENT ASSOCIATION')); ?></strong></h4>
                             <img src="<?php echo e(asset('photo/1753264204855401.jpg')); ?>" alt="Logo" class="w-20 h-20"
                                 style="border-radius: 50%; align-items: center; justify-content: center; display: block; margin-left: auto; margin-right: auto;" />


                         </div>
                         <div class="card-body">
                             
                             <br />
                             <div class="bmd-form-group<?php echo e($errors->has('email') ? ' has-danger' : ''); ?>">
                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <span class="input-group-text">
                                             <i class="material-icons">email</i>
                                         </span>
                                     </div>
                                     <input type="email" name="email" class="form-control"
                                         placeholder="<?php echo e(__('Email...')); ?>" required>
                                 </div>
                                 <?php if($errors->has('email')): ?>
                                     <div id="email-error" class="error text-danger pl-3" for="email"
                                         style="display: block;">
                                         <strong><?php echo e($errors->first('email')); ?></strong>
                                     </div>
                                 <?php endif; ?>
                             </div>
                             <div class="bmd-form-group<?php echo e($errors->has('password') ? ' has-danger' : ''); ?> mt-3">
                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <span class="input-group-text">
                                             <i class="material-icons">lock_outline</i>
                                         </span>
                                     </div>
                                     <input type="password" name="password" id="password" class="form-control"
                                         placeholder="<?php echo e(__('Password...')); ?>" required>
                                 </div>
                                 <?php if($errors->has('password')): ?>
                                     <div id="password-error" class="error text-danger pl-3" for="password"
                                         style="display: block;">
                                         <strong><?php echo e($errors->first('password')); ?></strong>
                                     </div>
                                 <?php endif; ?>
                             </div>
                             <div class="form-check mr-auto ml-3 mt-3">
                                 <label class="form-check-label">
                                     <input class="form-check-input" type="checkbox" name="remember"
                                         <?php echo e(old('remember') ? 'checked' : ''); ?>> <?php echo e(__('Remember me')); ?>

                                     <span class="form-check-sign">
                                         <span class="check"></span>
                                     </span>
                                 </label>
                             </div>
                         </div>
                         <div class="card-footer justify-content-center">
                             <button type="submit"
                                 class="btn btn-primary btn-link btn-lg"><?php echo e(__('Lets Go')); ?></button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>


     
     
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015)): ?>
<?php $component = $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015; ?>
<?php unset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015); ?>
<?php endif; ?>


 
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/auth/login.blade.php ENDPATH**/ ?>