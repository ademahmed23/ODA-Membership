<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="{{ route('front.news') }}">
                <img src="{{ asset('front/images/logo (1).png') }}" height="30em" width="30em">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="custom-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('front.news') }}">News</a></li>
                <li><a href="{{ route('front.announcement') }}">Announcement</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
