@extends('layouts.components.index')
@section('model','Harargee-Bahaa')
@section('count',$count)
@section('title','Harargee-Bahaa')
@section('insert','Harargee-Bahaa')
@section('icons','layout')
@section('route',route('zone10.create'))
@section('import',route('zone10.import'))

@section('table')
<livewire:zone10-table />
@endsection
