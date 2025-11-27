@extends('layouts.components.index')
@section('model','Wallaga-Lixaa')
@section('count',$count)
@section('title','Wallaga-Lixaa')
@section('insert','Wallaga-Lixaa')
@section('icons','layout')
@section('route',route('zone21.create'))
@section('import',route('zone21.import'))

@section('table')
<livewire:zone21-table />
@endsection
