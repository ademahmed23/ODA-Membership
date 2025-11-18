@extends('layouts.components.form')
@section('model','News')
@section('title','News')
@section('back',route('news.index'))
@section('type','Edit')

@section('form')
{{-- $table->string('title');
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('document')->nullable();
            $table->string('video')->nullable(); --}}
<form method="POST" action="{{ route('news.update',$news->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Title</strong>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ $news->title }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Content</strong>
            <textarea class="form-control" id="content" name="content" placeholder="Enter Content">{{ $news->content }}</textarea>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div>
            <strong>Image</strong>
            <input type="file" class="form-control" id="Image" name="Image" placeholder="Enter Image" value="{{ $news->image }}">
        </div>
        <img src="{{ asset($news->image) }}" alt="" width="200px" height="150px">
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div>
            <strong>Document</strong>
            <input type="file" class="form-control" id="Document" name="Document" placeholder="Enter Document" value="{{ $news->document }}">
        </div>
        <a href="{{ asset($news->document) }}" target="_blank">View Document</a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div>
            <strong>Video</strong>
            <input type="file" class="form-control" id="Video" name="Video" placeholder="Enter Video" value="{{ $news->video }}">
        </div>
        <video width="320" height="240" controls>
            <source src="{{ asset($news->video) }}" type="video/mp4">
        </video>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
@section('script')
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });

</script>
@endsection
