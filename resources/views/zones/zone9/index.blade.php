@extends('layouts.components.index')
@section('model','Gujii-Lixaa')
@section('count',$count)
@section('title','Gujii-Lixaa')
@section('insert','Gujii-Lixaa')
@section('icons','layout')
@section('route',route('zone9.create'))
@section('import',route('zone9.import'))

@section('table')
<livewire:zone9-table />
@endsection
