@extends('layouts.components.index')
@section('model','B-M-Sabbaataa')
@section('count',$count)
@section('title','B-M-Sabbaataa')
@section('insert','B-M-Sabbaataa')
@section('icons','layout')
@section('route',route('city17.create'))
@section('import',route('city17.import'))

@section('table')
<livewire:city17-table />
@endsection
