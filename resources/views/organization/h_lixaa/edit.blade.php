@extends('layouts.components.form')

@section('model','h_lixaa')
@section('title','Harargee Lixaa')
@section('back',route('h_lixaa.index'))
@section('type','Edit')
@section('form')

<form method="POST" action="{{ route('h_lixaa.update', $h_lixaa->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Member ID</strong>
            <input type="text" class="form-control" name="member_id"
                   value="{{ $h_lixaa->member_id }}" placeholder="Enter Member ID">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Organization Name</strong>
            <input type="text" class="form-control" name="organization_name"
                   value="{{ $h_lixaa->organization_name }}" placeholder="Enter Organization Name">
        </div>
    </div>

    {{-- Organization Type --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Organization Type</strong>
            <select class="form-select" name="organization_type">
                @foreach(json_decode($joption) as $option)
                    <option value="{{ $option->text }}"
                        {{ $h_lixaa->organization_type == $option->text ? 'selected' : '' }}>
                        {{ $option->text }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Woreda --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Woreda</strong>
            <select class="form-select" name="woreda">
                @foreach(json_decode($jsonOptions) as $option)
                    <option value="{{ $option->text }}"
                        {{ $h_lixaa->woreda == $option->text ? 'selected' : '' }}>
                        {{ $option->text }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Phone --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone Number</strong>
            <input type="number" class="form-control" name="phone_number"
                   value="{{ $h_lixaa->phone_number }}" placeholder="Enter Phone Number">
        </div>
    </div>

    {{-- Email --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email</strong>
            <input type="email" class="form-control" name="email"
                   value="{{ $h_lixaa->email }}" placeholder="Enter Email">
        </div>
    </div>

    {{-- Payment Period --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Payment Period</strong>
            <input type="text" class="form-control" name="payment_period"
                   value="{{ $h_lixaa->payment_period }}" placeholder="Enter Payment Period">
        </div>
    </div>

    {{-- Member Started --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Member Started</strong>
            <input type="date" class="form-control" name="member_started"
                   value="{{ $h_lixaa->member_started }}">
        </div>
    </div>

    {{-- Payment Amount --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Payment Amount</strong>
            <input type="number" class="form-control" name="payment"
                   value="{{ $h_lixaa->payment }}" placeholder="Enter Payment Amount">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</form>

@endsection
