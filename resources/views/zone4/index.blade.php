@extends('layouts.components.index')
@section('model','Baalee-Bahaa')
@section('count',$count)
@section('title','Baalee-Bahaa')
@section('insert','Baalee-Bahaa')
@section('icons','layout')
@section('route',route('zone4.create'))
@section('import',route('zone4.import'))
@section('filterAction', route('zone4.index'))
@section('filterName', 'woreda')
@section('filterLabel', 'Woreda')
@section('filterButton', 'Show Data')
@section('exportEnabled', true)
@section('exportRoute', url('zoneMember-export/' . $zone . '/' . $woreda))
@section('exportText', 'Download')

@section('table')
<livewire:zone4-table />
@endsection
