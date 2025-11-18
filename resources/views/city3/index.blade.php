@extends('layouts.components.index')
@section('model','B-M-Asallaa')
@section('count',$count)
@section('title','B-M-Asallaa')
@section('insert','B-M-Asallaa')
@section('icons','layout')
@section('route',route('city3.create'))
@section('import',route('city3.import'))

@section('table')
<livewire:city3-table />
@endsection
