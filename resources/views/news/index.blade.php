@extends('layouts.app')

@section('title', 'News — Forestry Ideas')
@section('page-title', 'News')

@section('content')
  @forelse($news as $item)
    <div class="mb-3 pl-4 border-l-[3px] border-forest-400 py-2 bg-forest-50 rounded-r text-sm">
      <strong class="text-forest-700">{{ $item->newsDatum }}</strong>
      <div class="mt-1 text-gray-700">{!! $item->newsText !!}</div>
    </div>
  @empty
    <p class="text-gray-500">No news available.</p>
  @endforelse
@endsection
