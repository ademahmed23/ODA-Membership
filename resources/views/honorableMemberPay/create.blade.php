@extends('layouts.components.form')
@section('model','Honorable Member Payment')
@section('title','Honorable Member Payment')
{{-- @section('back',route('{{ $model }}.index')) --}}
@section('type','Create')
@section('form')


<form method="POST" action="{{ route('honorableMemberPay.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name</strong>
            <input type="hidden" class="form-control" id="member_id" name="member_id" value="{{ $member->id }}">
            <input type="text" class="form-control" id="name" name="name" value="{{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }}" readonly>

        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Occupation</strong>
            <input type="text" class="form-control" id="position" name="position" value="{{ $member->position }}" readonly>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Amount</strong>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ $member->membership_fee }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Date</strong>
            <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
