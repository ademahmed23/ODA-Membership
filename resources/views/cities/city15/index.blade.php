@extends('layouts.components.index2')
@section('model','B-M-Roobee')
@section('count',$count)
@section('title','B-M-Roobee')
@section('insert','B-M-Roobee')
@section('icons','layout')
@section('route',route('city15.create'))
@section('import',route('city15.import'))

@section('table')
<livewire:city15-table />
@endsection
