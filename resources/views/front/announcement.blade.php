@extends('front.layouts.app')
@section('content')
@if($latest)
@if($latest->image)
<section class="module bg-dark-60 blog-page-header" data-background="{{ $latest->image }}" style="height: 32em;">
    @else
    <section class="module bg-dark-60 blog-page-header" data-background="{{ asset('front/images/blog_bg.jpg') }}" style="height: 32em;">

        @endif
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h2 class="module-title font-alt"><a href="/detail/{{ $latest->id }}/Announcement">{{ $latest->title }}</a></h2>
                    <div class="module-subtitle font-serif">{!! Str::limit($latest->content, 140, '...') !!}</div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="module">
        <div class="container">
            <div class="row multi-columns-row post-columns">
                @forelse ($announcements as $item)

                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="post">
                        <div class="post-thumbnail"><a href="/detail/{{ $item->id }}/Announcement"><img src="{{ $item->image }}" alt="Blog-post Thumbnail" /></a></div>
                        <div class="post-header font-alt">
                            <h2 class="post-title"><a href="/detail/{{ $item->id }}/Announcement">{{ $item->title }}</a></h2>
                            <div class="post-meta">&nbsp;| {{ ($item->created_at)->format('d M') }}
                            </div>
                        </div>
                        <div class="post-entry">
                            <p>{!! Str::limit($item->content, 80, '...') !!}</p>
                        </div>
                        <div class="post-more"><a class="more-link" href="/detail/{{ $item->id }}/Announcement">Read more</a></div>
                    </div>
                </div>
                @empty


                @endforelse

            </div>
            <div class="pagination font-alt">{{ $announcements->links() }}</div>
        </div>
    </section>


    @endsection
