@extends('layouts.components.index2')
@section('model','Regional')
@section('count',$count)
@section('title','Regional')
@section('insert','Regional')
@section('icons','layout')
@section('route',route('regional.create'))
@section('import',route('regional.import'))

@section('table')
<livewire:regional-table />
@endsection
