<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<?php echo $__env->make('front.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">

    <main>
        <div class="main">
            <?php echo $__env->yieldContent('content'); ?>
            <?php echo $__env->make('front.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    <!--
    JavaScripts
    =============================================
    -->
    <?php echo $__env->make('front.layouts.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/front/layouts/app.blade.php ENDPATH**/ ?>