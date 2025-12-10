@extends('layouts.components.index2')
@section('model','B-M-Walisoo')
@section('count',$count)
@section('title','B-M-Walisoo')
@section('insert','B-M-Walisoo')
@section('icons','layout')
@section('route',route('city19.create'))
@section('import',route('city19.import'))

@section('table')
<livewire:city19-table />
@endsection
