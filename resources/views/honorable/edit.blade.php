@extends('layouts.components.form')
@section('model','Honorable')
@section('title','Honorable')
@section('back',route('honorable.index'))
@section('type','Edit')

@section('form')
{{-- $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('gender');
            $table->integer('age');
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('woreda')->nullable();
            $table->string('email')->nullable();
            $table->string('position')->nullable();
            $table->string('membership_type')->nullable();
            $table->integer('membership_fee')->nullable(); --}}
<form method="POST" action="{{ route('honorable.update',$honorable->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>First Name</strong>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Name" value="{{ $honorable->first_name }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Middle Name</strong>
            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="{{ $honorable->middle_name }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Last Name</strong>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="{{ $honorable->last_name }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Sex</strong>
            <select class="form-control" id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Age</strong>
            <input type="number" class="form-control" id="age" name="age" placeholder="Enter Age" value="{{ $honorable->age }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Contact Number</strong>
            <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Enter Contact Number" value="{{ $honorable->contact_number }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Address/Workplace</strong>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="{{ $honorable->address }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Occupation</strong>
            <input type="text" class="form-control" id="position" name="position" placeholder="Enter Position" value="{{ $honorable->position }}">
        </div>
    </div>
    {{-- <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>MemberShip Type</strong>
            <input type="text" class="form-control" id="membership_type" name="membership_type" placeholder="Enter MemberShip Type" value="{{ $honorable->membership_type }}">
    </div>
    </div> --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>MemberShip Fee</strong>
            <input type="number" class="form-control" id="membership_fee" name="membership_fee" placeholder="Enter MemberShip Fee" value="{{ $honorable->membership_fee }}">
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
