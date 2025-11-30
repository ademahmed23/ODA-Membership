@extends('layouts.components.index2')
@section('model','B-M-Amboo')
@section('count',$count)
@section('title','B-M-Amboo')
@section('insert','B-M-Amboo')
@section('icons','layout')
@section('route',route('city2.create'))
@section('import',route('city2.import'))

@section('table')
<livewire:city2-table />
@endsection
