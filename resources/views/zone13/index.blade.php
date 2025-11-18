@extends('layouts.components.index')
@section('model','Iluu-Abbaa-Booraa')
@section('count',$count)
@section('title','Iluu-Abbaa-Booraa')
@section('insert','Iluu-Abbaa-Booraa')
@section('icons','layout')
@section('route',route('zone13.create'))
@section('import',route('zone13.import'))

@section('table')
<livewire:zone13-table />
@endsection
