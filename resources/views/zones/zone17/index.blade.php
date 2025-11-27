@extends('layouts.components.index')
@section('model','Shawaa-Kaabaa')
@section('count',$count)
@section('title','Shawaa-Kaabaa')
@section('insert','Shawaa-Kaabaa')
@section('icons','layout')
@section('route',route('zone17.create'))
@section('import',route('zone17.import'))
@section('filterAction', route('zone17.index'))
@section('filterName', 'woreda')
@section('filterLabel', 'Woreda')
@section('filterButton', 'Show Data')
@section('exportEnabled', true)
@section('exportRoute', url('zoneMember-export/' . $zone . '/' . $woreda))
@section('exportText', 'Download')


@section('table')
<livewire:zone17-table />
@endsection
