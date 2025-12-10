@extends('layouts.components.index2')
@section('model','B-M-Hoolotaa')
@section('count',$count)
@section('title','B-M-Hoolotaa')
@section('insert','B-M-Hoolotaa')
@section('icons','layout')
@section('route',route('city10.create'))
@section('import',route('city10.import'))

@section('table')
<livewire:city10-table />
@endsection
