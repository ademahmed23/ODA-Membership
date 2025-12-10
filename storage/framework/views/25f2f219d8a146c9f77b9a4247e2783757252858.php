<?php $__env->startSection('content'); ?>

    
<?php $__env->startSection('title', 'Roles'); ?>
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
                                        
                                        <i class="bx bxs-group" style="font-size: 2.5em;color:green;"></i>
                                        
                                    </div>
                                </div>
                                <span>Roles</span>
                                <h3 class="card-title text-nowrap mb-1"><?php echo e($roles->total()); ?></h3>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Roles</h4>
                            <p class="card-category"> Here you can manage Roles</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right" style="text-align: right;">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-create')): ?>
                                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">Add Roles</a>
                                    <?php endif; ?>



                                </div>


                            </div>
                            <?php echo $__env->make('roles.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th>
                                                Number
                                            </th>
                                            <th>
                                                Name
                                            </th>
                                            <th class="text-right" width="25%">>
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(++$i); ?></td>

                                                <td><?php echo e($role->name); ?></td>



                                                <td class="td-actions text-right" style="width:75px;overflow: hidden;">

                                                    <div class="flex items-center space-x-4 text-sm">
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-edit')): ?>
                                                            <a class="btn btn-primary"
                                                                href="<?php echo e(route('roles.edit', $role->id)); ?>">Edit</a>
                                                        <?php endif; ?>

                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-delete')): ?>
                                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']); ?>


                                                            <?php echo Form::submit('Delete', ['class' => 'btn btn-danger']); ?>


                                                            <?php echo Form::close(); ?>

                                                        <?php endif; ?>

                                                    </div>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>
                                <?php echo $roles->render(); ?>











                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['activePage' => 'roles', 'titlePage' => __('Role')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/roles/index.blade.php ENDPATH**/ ?>