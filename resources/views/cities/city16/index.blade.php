@extends('layouts.components.index2')
@section('model','B-M-Shaashaamannee')
@section('count',$count)
@section('title','B-M-Shaashaamannee')
@section('insert','B-M-Shaashaamannee')
@section('icons','layout')
@section('route',route('city16.create'))
@section('import',route('city16.import'))

@section('table')
<livewire:city16-table />
@endsection
