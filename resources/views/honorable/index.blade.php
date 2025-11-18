@extends('layouts.components.index')
@section('model','Honorable')
@section('count',$count)
@section('title','Honorable')
@section('insert','Honorable')
@section('icons','medal')
@section('route',route('honorable.create'))
@section('import',route('honorable.import'))

@section('table')
<livewire:honorable-table />
@endsection
