@extends('layouts.components.index')
@section('model','Jimmaa')
@section('count',$count)
@section('title','Jimmaa')
@section('insert','Jimmaa')
@section('icons','layout')
@section('route',route('zone14.create'))
@section('import',route('zone14.import'))

@section('table')
<livewire:zone14-table />
@endsection
