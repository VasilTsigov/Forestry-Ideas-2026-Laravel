@extends('layouts.app')

@section('title', 'Forestry Ideas — An International Journal')
@section('page-title', 'Forestry Ideas')
@section('page-subtitle', 'An International Journal of Forestry Sciences')

@section('content')
  @if($homeContent)
    <div class="prose prose-sm max-w-none leading-relaxed text-gray-800">
      {!! $homeContent->homeText !!}
    </div>
  @endif

  @if($latestNews->isNotEmpty())
    <hr class="border-gray-200 my-6" />
    <h2 class="text-lg font-bold text-navy-800 mb-4">Latest News</h2>
    @foreach($latestNews as $item)
      <div class="mb-3 pl-4 border-l-[3px] border-forest-400 py-2 bg-forest-50 rounded-r text-sm">
        <strong class="text-forest-700">{{ $item->newsDatum }}</strong>
        <div class="mt-1 text-gray-700">{!! $item->newsText !!}</div>
      </div>
    @endforeach
    <p class="mt-3 text-sm">
      <a href="{{ route('news.index') }}" class="font-semibold text-forest-600 hover:text-forest-800">All news &raquo;</a>
    </p>
  @endif
@endsection
