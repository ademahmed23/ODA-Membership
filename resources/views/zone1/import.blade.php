@extends('layouts.components.form')
@section('model','Arsii')
@section('title','Arsii')
@section('back',route('zone1.index'))
@section('type','Import')
@section('form')


<form method="POST" action="{{ route('zone1.import') }}" enctype="multipart/form-data">
    @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>File</strong>
            <input type="file" class="form-control" id="file" name="file" placeholder="Enter File">
        </div>
        @error('file')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
