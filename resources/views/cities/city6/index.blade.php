@extends('layouts.components.index')
@section('model','B-M-Buraayyuu')
@section('count',$count)
@section('title','B-M-Buraayyuu')
@section('insert','B-M-Buraayyuu')
@section('icons','layout')
@section('route',route('city6.create'))
@section('import',route('city6.import'))

@section('table')
<livewire:city6-table />
@endsection
