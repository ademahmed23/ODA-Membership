@extends('layouts.components.index2')
@section('model','News')
@section('count',$count)
@section('title','News')
@section('insert','News')
@section('icons','news')
@section('route',route('news.create'))

@section('table')
<livewire:news-table />
@endsection
