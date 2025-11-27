@extends('layouts.components.index')
@section('model','B-M-Naqamtee')
@section('count',$count)
@section('title','B-M-Naqamtee')
@section('insert','B-M-Naqamtee')
@section('icons','layout')
@section('route',route('city14.create'))
@section('import',route('city14.import'))

@section('table')
<livewire:city14-table />
@endsection
