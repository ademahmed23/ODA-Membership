<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="<?php echo e(route('front.news')); ?>">
                <img src="<?php echo e(asset('front/images/logo (1).png')); ?>" height="30em" width="30em">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="custom-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo e(route('front.news')); ?>">News</a></li>
                <li><a href="<?php echo e(route('front.announcement')); ?>">Announcement</a></li>
                <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/front/layouts/nav.blade.php ENDPATH**/ ?>