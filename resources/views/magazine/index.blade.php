@extends('layouts.app')

@section('title', 'Contents — Forestry Ideas')
@section('page-title', 'Contents')
@section('page-subtitle', 'Full list of published issues')

@section('content')
  <div class="bg-white border border-gray-200 rounded-lg p-5">
  @foreach($magazines as $magazine)
    <div class="flex items-center justify-between gap-3 py-2 border-b border-gray-100 last:border-0">
      <div class="flex-1 text-sm">
        <a href="{{ route('magazine.issues', ['journal' => $magazine->journalID]) }}"
           class="font-semibold text-forest-600 hover:text-forest-800">
          {{ $magazine->journalTitle }},
          {{ $magazine->journalYear }},
          Vol. {{ $magazine->journalVolume }},
          No {{ $magazine->journalNr }}
        </a>
        <span class="text-gray-400 font-normal text-xs ml-1">({{ $magazine->articles_count }})</span>
      </div>
      <div class="flex gap-2 shrink-0">
        @if($magazine->journalFileContent)
          <a href="{{ route('download.journal-content', $magazine) }}"
             class="inline-flex items-center gap-1 text-xs px-2.5 py-1 border border-forest-300 rounded text-forest-600 bg-forest-50 hover:bg-forest-600 hover:text-white transition-colors font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Content
          </a>
        @endif
        @if($magazine->journalFile)
          <a href="{{ route('download.journal', $magazine) }}"
             class="inline-flex items-center gap-1 text-xs px-2.5 py-1 border border-forest-300 rounded text-forest-600 bg-forest-50 hover:bg-forest-600 hover:text-white transition-colors font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17a2 2 0 002 2h14a2 2 0 002-2v-1" />
            </svg>
            PDF
          </a>
        @endif
      </div>
    </div>
  @endforeach

  @if($magazines->isEmpty())
    <p class="text-gray-500">No journals in database.</p>
  @endif
  </div>
@endsection
