@extends('layouts.components.index')
@section('model','Shawaa-Kibbaaa-Lixaa')
@section('count',$count)
@section('title','Shawaa-Kibbaaa-Lixaa')
@section('insert','Shawaa-Kibbaaa-Lixaa')
@section('icons','layout')
@section('route',route('zone18.create'))
@section('import',route('zone18.import'))

@section('table')
<livewire:zone18-table />
@endsection
