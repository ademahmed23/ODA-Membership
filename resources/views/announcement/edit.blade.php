@extends('layouts.components.form')
@section('model','Announcement')
@section('title','Announcement')
@section('back',route('announcement.index'))
@section('type','Edit')

@section('form')

<form method="POST" action="{{ route('announcement.update',$announcement->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Title</strong>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ $announcement->title }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Content</strong>
            <textarea class="form-control" id="content" name="content" placeholder="Enter Content">{{ $announcement->content }}</textarea>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div>
            <strong>Image</strong>
            <input type="file" class="form-control" id="Image" name="Image" placeholder="Enter Image" value="{{ $announcement->image }}">
        </div>
        <img src="{{ asset($announcement->image) }}" alt="" width="200px" height="150px">
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
