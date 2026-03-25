@extends('layouts.app')

@section('title', 'News — Forestry Ideas')
@section('page-title', 'News')

@section('content')
  <div class="bg-white border border-gray-200 rounded-lg p-5">
    @forelse($news as $item)
      <div class="mb-3 py-2 border-b border-gray-100 last:border-0 text-sm">
        <strong class="text-forest-700">{{ $item->newsDatum }}</strong>
        <div class="mt-1 text-gray-700">{!! $item->newsText !!}</div>
      </div>
    @empty
      <p class="text-gray-500">No news available.</p>
    @endforelse
  </div>
@endsection
