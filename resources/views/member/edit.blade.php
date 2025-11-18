@extends('layouts.components.form')
@section('model','Member')
@section('title','Member')
@section('back',route('member.index'))
@section('type','Edit')

@section('form')

<form method="POST" action="{{ route('member.update',$member->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name</strong>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $member->name }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email</strong>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $member->email }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone</strong>
            <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="{{ $member->phone }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Department</strong>
            <input type="text" class="form-control" id="department" name="department" placeholder="Enter Department" value="{{ $member->department }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Designation</strong>
            <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Designation" value="{{ $member->designation }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Workplace</strong>
            <input type="text" class="form-control" id="workplace" name="workplace" placeholder="Enter Workplace" value="{{ $member->workplace }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div>
            <strong>Photo</strong>
            <input type="file" class="form-control" id="photo" name="photo" placeholder="Enter Photo" value="{{ $member->photo }}">
        </div>
        <img src="{{ asset($member->photo) }}" alt="" width="200px" height="150px">
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
