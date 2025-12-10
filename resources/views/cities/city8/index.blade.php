@extends('layouts.components.index2')
@section('model','B-M-Finfinnee')
@section('count',$count)
@section('title','B-M-Finfinnee')
@section('insert','B-M-Finfinnee')
@section('icons','layout')
@section('route',route('city8.create'))
@section('import',route('city8.import'))

@section('table')
<livewire:city8-table />
@endsection
