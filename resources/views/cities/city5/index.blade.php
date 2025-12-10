@extends('layouts.components.index2')
@section('model','B-M-Bishooftuu')
@section('count',$count)
@section('title','B-M-Bishooftuu')
@section('insert','B-M-Bishooftuu')
@section('icons','layout')
@section('route',route('city5.create'))
@section('import',route('city5.import'))

@section('table')
<livewire:city5-table />
@endsection
