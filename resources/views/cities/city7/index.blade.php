@extends('layouts.components.index2')
@section('model','B-M-Dukam')
@section('count',$count)
@section('title','B-M-Dukam')
@section('insert','B-M-Dukam')
@section('icons','layout')
@section('route',route('city7.create'))
@section('import',route('city7.import'))

@section('table')
<livewire:city7-table />
@endsection
