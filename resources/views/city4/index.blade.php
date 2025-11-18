@extends('layouts.components.index')
@section('model','B-M-Baatuu')
@section('count',$count)
@section('title','B-M-Baatuu')
@section('insert','B-M-Baatuu')
@section('icons','layout')
@section('route',route('city4.create'))
@section('import',route('city4.import'))

@section('table')
<livewire:city4-table />
@endsection
