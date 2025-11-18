@extends('layouts.components.index')
@section('model','Harargee-Lixaa')
@section('count',$count)
@section('title','Harargee-Lixaa')
@section('insert','Harargee-Lixaa')
@section('icons','layout')
@section('route',route('zone11.create'))
@section('import',route('zone11.import'))

@section('table')
<livewire:zone11-table />
@endsection
