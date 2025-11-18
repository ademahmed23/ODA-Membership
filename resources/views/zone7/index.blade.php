@extends('layouts.components.index')
@section('model','Finfinnee')
@section('count',$count)
@section('title','Finfinnee')
@section('insert','Finfinnee')
@section('icons','layout')
@section('route',route('zone7.create'))
@section('import',route('zone7.import'))

@section('table')
<livewire:zone7-table />
@endsection
