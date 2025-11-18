@extends('layouts.components.index')
@section('model','B-M-Mojoo')
@section('count',$count)
@section('title','B-M-Mojoo')
@section('insert','B-M-Mojoo')
@section('icons','layout')
@section('route',route('city13.create'))
@section('import',route('city13.import'))

@section('table')
<livewire:city13-table />
@endsection
