@extends('layouts.components.index')
@section('model','B-M-Jimmaa')
@section('count',$count)
@section('title','B-M-Jimmaa')
@section('insert','B-M-Jimmaa')
@section('icons','layout')
@section('route',route('city11.create'))
@section('import',route('city11.import'))

@section('table')
<livewire:city11-table />
@endsection
