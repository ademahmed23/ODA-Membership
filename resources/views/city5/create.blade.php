@extends('layouts.components.form')
@section('model','B-M-Bishooftuu')
@section('title','B-M-Bishooftuu')
@section('back',route('city5.index'))
@section('type','Create')
@section('form')


<form method="POST" action="{{ route('city5.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>First Name</strong>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Name">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Middle Name</strong>
            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Last Name</strong>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Sex</strong>
            <select class="form-select" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Age</strong>
            <input type="number" class="form-control" id="age" name="age" placeholder="Enter Age">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Address/Workplace</strong>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Contact Number</strong>
            <input type="number" class="form-control" id="contact_number" name="contact_number" placeholder="Enter Contact Number">
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
            <strong>Occupation</strong>
            <select class="form-select" name="position">
                <option value="City/Town Resident">City/Town Resident</option>
                <option value="Merchant">Merchant</option>
                <option value="Government Workers">Government Workers</option>
                <option value="Farmers">Farmers</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Membership type</strong>
            <select class="form-select" name="membership_type">
                <option value="Regular">Regular</option>
                <option value="Associate">Associate</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Membership Fee</strong>
            <input type="number" class="form-control" id="membership_fee" name="membership_fee" placeholder="Enter Membership Fee">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
