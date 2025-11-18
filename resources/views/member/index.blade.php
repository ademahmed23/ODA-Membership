@extends('layouts.components.index')
@section('model','Members')
@section('count',$count)
@section('title','Members')
@section('insert','Member')
@section('route',route('member.create'))

@section('content')
<livewire:member-table />
@endsection
