@extends('layouts.app')

@section('title', 'Subscription — Forestry Ideas')
@section('page-title', 'Subscription')

@section('content')
  <div class="db-content prose prose-sm max-w-none text-gray-800 leading-relaxed">
    {!! $page->content !!}
  </div>
@endsection
