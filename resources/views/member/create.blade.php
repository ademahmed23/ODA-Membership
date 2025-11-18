@extends('layouts.components.form')
@section('model','Member')
@section('title','Member')
@section('back',route('member.index'))
@section('type','Create')
@section('form')

{{-- $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('workplace')->nullable();
            $table->string('photo')->nullable(); --}}
<form method="POST" action="{{ route('member.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name</strong>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email</strong>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone</strong>
            <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Department</strong>
            <input type="text" class="form-control" id="department" name="department" placeholder="Enter Department">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Designation</strong>
            <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Designation">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Workplace</strong>
            <input type="text" class="form-control" id="workplace" name="workplace" placeholder="Enter Workplace">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div>
            <strong>Photo</strong>
            <input type="file" name="photo" class="form-control">

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
