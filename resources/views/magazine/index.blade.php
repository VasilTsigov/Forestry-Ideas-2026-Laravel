@extends('layouts.app')

@section('title', 'Contents — Forestry Ideas')
@section('page-title', 'Contents')
@section('page-subtitle', 'Full list of published issues')

@section('content')
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
          <a href="{{ asset('files/journal_content/' . $magazine->journalFileContent) }}"
             class="text-xs px-2.5 py-1 border border-forest-300 rounded text-forest-600 bg-forest-50 hover:bg-forest-600 hover:text-white transition-colors font-semibold">
            [ Content ]
          </a>
        @endif
        @if($magazine->journalFile)
          <a href="{{ route('download.journal', $magazine) }}"
             class="text-xs px-2.5 py-1 border border-forest-300 rounded text-forest-600 bg-forest-50 hover:bg-forest-600 hover:text-white transition-colors font-semibold">
            [ Download ]
          </a>
        @endif
      </div>
    </div>
  @endforeach

  @if($magazines->isEmpty())
    <p class="text-gray-500">No journals in database.</p>
  @endif
@endsection
