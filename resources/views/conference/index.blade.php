@extends('layouts.app')

@section('title', 'Conferences — Forestry Ideas')
@section('page-title', 'Conferences')

@section('content')
  @forelse($conferences as $conference)
    <div class="py-2.5 border-b border-gray-100 last:border-0 text-sm">
      <span class="text-gray-800">{!! $conference->confTitle !!}</span>
      @if($conference->confDate)
        <span class="text-gray-500 italic ml-1">({{ $conference->confDate }})</span>
      @endif
      @if($conference->confFileName)
        <span class="mx-1 text-gray-300">&mdash;</span>
        <a href="{{ route('download.conference', $conference->confID) }}"
           class="font-semibold text-forest-600 hover:text-forest-800 text-xs">Download PDF</a>
      @endif
    </div>
  @empty
    <p class="text-gray-500">No conferences listed.</p>
  @endforelse
@endsection
