@extends('layouts.app')

@section('title', 'Forestry Ideas — An International Journal')
@section('page-title', 'Forestry Ideas')
@section('page-subtitle', 'An International Journal of Forestry Sciences')

@section('content')
  @if($homeContent)
    <div class="bg-white border border-gray-200 rounded-lg p-5">
      <div class="prose prose-sm max-w-none leading-relaxed text-gray-800">
        {!! $homeContent->homeText !!}
      </div>
    </div>
  @endif

@endsection
