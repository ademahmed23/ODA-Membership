@extends('layouts.components.form')

@section('model','Arsii Lixaa')
@section('title','Arsii Lixaa')
@section('back',route('arsii_lixaa.index'))
@section('type','Edit')
@section('form')

<form method="POST" action="{{ route('arsii_lixaa.update',$arsii_lixaa->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Member ID</strong>
            <input type="text" class="form-control" id="member_id" name="member_id" placeholder="Enter Member ID" value="{{$arsii_lixaa->member_id}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Organization Name</strong>
            <input type="text" class="form-control" id="organization_name" name="organization_name" placeholder="Enter Organization Name" value="{{$arsii_lixaa->organization_name}}">
        </div>
    </div>

    {{-- <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Organization Type</strong>
            <input type="text" class="form-control" id="organization_type" name="organization_type" placeholder="Enter Organization Type">
        </div>
    </div> --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Organization Type</strong>
            <select class="form-select" name="organization_type">
                @foreach(json_decode($joption) as $option)
                <option value="{{ $option->text }}">{{ $option->text }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Woreda</strong>
            <select class="form-select" name="woreda">
                @foreach(json_decode($jsonOptions) as $option)
                <option value="{{ $option->text }}">{{ $option->text }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone Number</strong>
            <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" value="{{$arsii_lixaa->phone_number}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email</strong>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{$arsii_lixaa->email}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Payment Period</strong>
            <input type="text" class="form-control" id="payment_period" name="payment_period" placeholder="Enter Payment Period" value="{{$arsii_lixaa->payment_period}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Member Started</strong>
            <input type="date" class="form-control" id="member_started" name="member_started" value="{{$arsii_lixaa->member_started}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Payment Amount</strong>
            <input type="number" class="form-control" id="paymemt" name="paymemt" placeholder="Enter Payment Amount" value="{{$arsii_lixaa->payment}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

@endsection
