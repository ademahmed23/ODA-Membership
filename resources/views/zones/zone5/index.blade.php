@extends('layouts.components.index')
@section('model','Booranaa')
@section('count',$count)
@section('title','Booranaa')
@section('insert','Booranaa')
@section('icons','layout')
@section('route',route('zone5.create'))
@section('import',route('zone5.import'))
@section('filterAction', route('zone1.index'))
@section('filterName', 'woreda')
@section('filterLabel', 'Woreda')
@section('filterButton', 'Show Data')
@section('exportEnabled', true)
@section('exportRoute', url('zoneMember-export/' . $zone . '/' . $woreda))
@section('exportText', 'Download')


@section('table')
<livewire:zone5-table />
@endsection
