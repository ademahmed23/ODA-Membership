@extends('layouts.components.index2')
@section('model','B-M-Sulultaa')
@section('count',$count)
@section('title','B-M-Sulultaa')
@section('insert','B-M-Sulultaa')
@section('icons','layout')
@section('route',route('city18.create'))
@section('import',route('city18.import'))

@section('table')
<livewire:city18-table />
@endsection
