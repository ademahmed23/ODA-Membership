@extends('layouts.components.index')
@section('model','Shawaa-Bahaa')
@section('count',$count)
@section('title','Shawaa-Bahaa')
@section('insert','Shawaa-Bahaa')
@section('icons','layout')
@section('route',route('zone16.create'))
@section('import',route('zone16.import'))

@section('table')
<livewire:zone16-table />
@endsection
