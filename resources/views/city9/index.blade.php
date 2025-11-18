@extends('layouts.components.index')
@section('model','B-M-Galaan')
@section('count',$count)
@section('title','B-M-Galaan')
@section('insert','B-M-Galaan')
@section('icons','layout')
@section('route',route('city9.create'))
@section('import',route('city9.import'))

@section('table')
<livewire:city9-table />
@endsection
