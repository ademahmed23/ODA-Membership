@extends('layouts.components.index')
@section('model','Qeellam-Wallaga')
@section('count',$count)
@section('title','Qeellam-Wallaga')
@section('insert','Qeellam-Wallaga')
@section('icons','layout')
@section('route',route('zone15.create'))
@section('import',route('zone15.import'))

@section('table')
<livewire:zone15-table />
@endsection
