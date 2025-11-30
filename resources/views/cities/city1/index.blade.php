@extends('layouts.components.index2')
@section('model','B-M-Adaamaa')
@section('count',$count)
@section('title','B-M-Adaamaa')
@section('insert','B-M-Adaamaa')
@section('icons','layout')
@section('route',route('city1.create'))
@section('import',route('city1.import'))


@section('table')
<livewire:city1-table />
@endsection
