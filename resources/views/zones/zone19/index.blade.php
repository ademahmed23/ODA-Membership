@extends('layouts.components.index')
@section('model','Shawaa-Lixaa')
@section('count',$count)
@section('title','Shawaa-Lixaa')
@section('insert','Shawaa-Lixaa')
@section('icons','layout')
@section('route',route('zone19.create'))
@section('import',route('zone19.import'))

@section('table')
<livewire:zone19-table />
@endsection
