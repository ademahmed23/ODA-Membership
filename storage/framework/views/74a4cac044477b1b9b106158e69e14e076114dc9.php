<?php $__env->startSection('content'); ?>
<?php if($latest): ?>
<?php if($latest->image): ?>
<section class="module bg-dark-60 blog-page-header" data-background="<?php echo e($latest->image); ?>" style="height: 32em;">
    <?php else: ?>
    <section class="module bg-dark-60 blog-page-header" data-background="<?php echo e(asset('front/images/blog_bg.jpg')); ?>" style="height: 32em;">
        <?php endif; ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h2 class="module-title font-alt"><a href="/detail/<?php echo e($latest->id); ?>/News"><?php echo e($latest->title); ?></a></h2>
                    <div class="module-subtitle font-serif"><?php echo Str::limit($latest->content, 140, '...'); ?></div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <section class="module">
        <div class="container">
            <div class="row multi-columns-row post-columns">
                <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="post">
                        <div class="post-thumbnail"><a href="/detail/<?php echo e($item->id); ?>/News"><img src="<?php echo e($item->image); ?>" alt="Blog-post Thumbnail" /></a></div>
                        <div class=" post-header font-alt">
                            <h2 class="post-title"><a href="/detail/<?php echo e($item->id); ?>/News"><?php echo e($item->title); ?></a></h2>
                            <div class="post-meta">&nbsp;| <?php echo e(($item->created_at)->format('d M')); ?>

                            </div>
                        </div>
                        <div class="post-entry">
                            <p><?php echo Str::limit($item->content, 80, '...'); ?></p>
                        </div>
                        <div class="post-more"><a class="more-link" href="/detail/<?php echo e($item->id); ?>/News">Read more</a></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


                <?php endif; ?>

            </div>
            <div class="pagination font-alt"><?php echo e($news->links()); ?></div>

        </div>
    </section>


    <?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/front/news.blade.php ENDPATH**/ ?>