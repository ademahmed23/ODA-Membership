@extends('layouts.components.index')
@section('model','Wallaga-Bahaa')
@section('count',$count)
@section('title','Wallaga-Bahaa')
@section('insert','Wallaga-Bahaa')
@section('icons','layout')
@section('route',route('zone20.create'))
@section('import',route('zone20.import'))

@section('table')
<livewire:zone20-table />
@endsection
