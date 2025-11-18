@extends('layouts.components.form')
@section('model','Announcement')
@section('title','Announcement')
@section('back',route('announcement.index'))
@section('type','Create')
@section('form')
<form method="POST" action="{{ route('announcement.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Title</strong>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Content</strong>
            <textarea class="form-control" id="content" name="content" placeholder="Enter Content"></textarea>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div>
            <strong>Image</strong>
            <input type="file" name="image" class="form-control">

        </div>
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
