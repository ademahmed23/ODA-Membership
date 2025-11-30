@extends('layouts.components.form')

@section('model','Shawaa Kaabaa')
@section('title','Shawaa Kaabaa ')
@section('back',route('sh_kaabaa.index'))
@section('type','Edit')
@section('form')

<form method="POST" action="{{ route('sh_kaabaa.update', $sh_kaabaa->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Member ID</strong>
            <input type="text" class="form-control" name="member_id"
                   value="{{ $sh_kaabaa->member_id }}" placeholder="Enter Member ID">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Organization Name</strong>
            <input type="text" class="form-control" name="organization_name"
                   value="{{ $sh_kaabaa->organization_name }}" placeholder="Enter Organization Name">
        </div>
    </div>

    {{-- Organization Type --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Organization Type</strong>
            <select class="form-select" name="organization_type">
                @foreach(json_decode($joption) as $option)
                    <option value="{{ $option->text }}"
                        {{ $sh_kaabaa->organization_type == $option->text ? 'selected' : '' }}>
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
                        {{ $sh_kaabaa->woreda == $option->text ? 'selected' : '' }}>
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
                   value="{{ $sh_kaabaa->phone_number }}" placeholder="Enter Phone Number">
        </div>
    </div>

    {{-- Email --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email</strong>
            <input type="email" class="form-control" name="email"
                   value="{{ $sh_kaabaa->email }}" placeholder="Enter Email">
        </div>
    </div>

    {{-- Payment Period --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Payment Period</strong>
            <input type="text" class="form-control" name="payment_period"
                   value="{{ $sh_kaabaa->payment_period }}" placeholder="Enter Payment Period">
        </div>
    </div>

    {{-- Member Started --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Member Started</strong>
            <input type="date" class="form-control" name="member_started"
                   value="{{ $sh_kaabaa->member_started }}">
        </div>
    </div>

    {{-- Payment Amount --}}
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Payment Amount</strong>
            <input type="number" class="form-control" name="payment"
                   value="{{ $sh_kaabaa->payment }}" placeholder="Enter Payment Amount">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</form>

@endsection
