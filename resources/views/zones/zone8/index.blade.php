@extends('layouts.components.index')
@section('model','Gujii')
@section('count',$count)
@section('title','Gujii')
@section('insert','Gujii')
@section('icons','layout')
@section('route',route('zone8.create'))
@section('import',route('zone8.import'))

@section('table')
<livewire:zone8-table />
@endsection
