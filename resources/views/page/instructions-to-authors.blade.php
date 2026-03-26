@extends('layouts.app')

@section('title', 'Instructions to Authors — Forestry Ideas')
@section('page-title', 'Instructions to Authors')

@section('content')
  <div class="bg-white border border-gray-200 rounded-lg p-5">
    <div class="db-content prose max-w-none text-gray-800 leading-relaxed">
      {!! $page->instrText !!}
    </div>
  </div>
@endsection
