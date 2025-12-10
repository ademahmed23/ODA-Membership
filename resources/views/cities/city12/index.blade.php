@extends('layouts.components.index2')
@section('model','B-M-L_Xaafoo')
@section('count',$count)
@section('title','B-M-L_Xaafoo')
@section('insert','B-M-L_Xaafoo')
@section('icons','layout')
@section('route',route('city12.create'))
@section('import',route('city12.import'))

@section('table')
<livewire:city12-table />
@endsection
