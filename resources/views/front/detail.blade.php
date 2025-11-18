@extends('front.layouts.app')
@section('content')
<section class="module-small">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3 sidebar">
                <div class="widget">
                    <h5 class="widget-title font-alt">Popular Posts</h5>
                    <ul class="widget-posts">
                        @forelse($latests as $latest)

                        <li class="clearfix">
                            <div class="widget-posts-image"><a href="#"><img src="{{ asset($latest->image) }}" alt="Post Thumbnail" /></a></div>
                            <div class="widget-posts-body">
                                <div class="widget-posts-title"><a href="#">{{ $latest->title }}</a></div>
                                <div class="widget-posts-meta">{{ ($latest->created_at)->format('d M') }}</div>
                            </div>
                        </li>
                        @empty
                        @endforelse

                    </ul>
                </div>
            </div>
            <div class="col-sm-8 col-sm-offset-1">
                <div class="post">
                    <div class="post-thumbnail"><img src="{{ asset($detail->image) }}" alt="Blog Featured Image" /></div>
                    <div class="post-header font-alt">
                        <h1 class="post-title">{{ $detail->title }}</h1>
                        <div class="post-meta">|{{($detail->created_at)->format('d M')}}
                        </div>
                    </div>
                    <div class="post-entry">
                        <p>{!! $detail->content !!}</p>
                    </div>
                </div>
                @if($detail->video)
                <div class="post-thumbnail">
                    {{-- video --}}

                </div>
                @endif
            </div>
        </div>
    </div>
</section>


@endsection
