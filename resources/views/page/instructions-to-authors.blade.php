@extends('layouts.app')

@section('title', 'Instructions to Authors — Forestry Ideas')
@section('page-title', 'Instructions to Authors')

@section('content')
  <div class="db-content prose prose-sm max-w-none text-gray-800 leading-relaxed">
    {!! $page->instrText !!}
  </div>
@endsection
