@extends('layouts.components.index2')
@section('model','Announcement')
@section('count',$count)
@section('title','Announcement')
@section('insert','Announcement')
@section('icons','microphone')
@section('route',route('announcement.create'))
@section('import',route('city1.import'))

@section('table')
<livewire:announcement-table />
@endsection
