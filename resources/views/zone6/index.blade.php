@extends('layouts.components.index')
@section('model','Bunno- Baddalle')
@section('count',$count)
@section('title','Bunno- Baddalle')
@section('insert','Bunno- Baddalle')
@section('icons','layout')
@section('route',route('zone6.create'))
@section('import',route('zone6.import'))

@section('table')
<livewire:zone6-table />
@endsection
