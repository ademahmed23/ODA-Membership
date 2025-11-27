@extends('layouts.components.index')
@section('model','Horroo-Guduruu-Wallaga')
@section('count',$count)
@section('title','Horroo-Guduruu-Wallaga')
@section('insert','Horroo-Guduruu-Wallaga')
@section('icons','layout')
@section('route',route('zone12.create'))
@section('import',route('zone12.import'))

@section('table')
<livewire:zone12-table />
@endsection
