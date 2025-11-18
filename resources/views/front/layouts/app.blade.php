<!DOCTYPE html>
<html lang="en-US" dir="ltr">
@include('front.layouts.header')
<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>
        <div class="page-loader">
            <div class="loader">Loading...</div>
        </div>
        @include('front.layouts.nav')
        <div class="main">
            @yield('content')
            @include('front.layouts.footer')
        </div>

        <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    <!--
    JavaScripts
    =============================================
    -->
    @include('front.layouts.script')
</body>
</html>
