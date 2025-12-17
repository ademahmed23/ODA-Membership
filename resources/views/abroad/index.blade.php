@extends('layouts.components.index2')
@section('model','Abroad')
@section('count',$count)
@section('title','Abroad')
@section('insert','Abroad')
@section('icons','layout')
@section('route',route('abroad.create'))
@section('import',route('abroad.import'))

@section('table')
<livewire:abroad-table />
@endsection
