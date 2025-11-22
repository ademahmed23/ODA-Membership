@extends('layouts.components.form')

@section('model','Arsii')
@section('title','Arsii')
@section('back',route('arsii.index'))
@section('type','Edit')
@section('form')

<form method="POST" action="{{ route('arsii.update',$arsii->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Member ID</strong>
            <input type="text" class="form-control" id="member_id" name="member_id" placeholder="Enter Member ID" value="{{$arsii->member_id}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Organization Name</strong>
            <input type="text" class="form-control" id="organization_name" name="organization_name" placeholder="Enter Organization Name" value="{{$arsii->organization_name}}">
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
            <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" value="{{$arsii->phone_number}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email</strong>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{$arsii->email}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Payment Period</strong>
            <input type="text" class="form-control" id="payment_period" name="payment_period" placeholder="Enter Payment Period" value="{{$arsii->payment_period}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Member Started</strong>
            <input type="date" class="form-control" id="member_started" name="member_started" value="{{$arsii->member_started}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Payment Amount</strong>
            <input type="number" class="form-control" id="paymemt" name="paymemt" placeholder="Enter Payment Amount" value="{{$arsii->payment}}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

@endsection
