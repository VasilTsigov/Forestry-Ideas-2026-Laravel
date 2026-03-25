@extends('layouts.app')

@section('title', 'Publication Ethics — Forestry Ideas')
@section('page-title', 'Publication Ethics')

@section('content')
  <div class="bg-white border border-gray-200 rounded-lg p-5">
    <div class="db-content prose prose-sm max-w-none text-gray-800 leading-relaxed">
      {!! $page->content !!}
    </div>
  </div>
@endsection
