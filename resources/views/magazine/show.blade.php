@extends('layouts.app')

@section('title', $magazine->journalTitle . ' ' . $magazine->journalYear . ' — Forestry Ideas')
@section('page-title', $magazine->journalTitle)
@section('page-subtitle', $magazine->journalYear . ', Vol. ' . $magazine->journalVolume . ', No. ' . $magazine->journalNr)

@section('content')
  @if($magazine->journalFile)
    <div class="mb-5">
      <a href="{{ route('download.journal', $magazine) }}"
         class="inline-flex items-center gap-2 px-4 py-2 bg-forest-600 text-white rounded font-semibold text-sm hover:bg-forest-700 transition-colors">
        Download full issue (PDF)
      </a>
      @if($magazine->journalCount)
        <span class="ml-2 text-gray-400 text-xs">{{ $magazine->journalCount }} downloads</span>
      @endif
    </div>
  @endif

  @forelse($magazine->articles as $article)
    <div class="bg-white border border-gray-200 rounded-lg px-5 py-4 mb-3 hover:shadow-md transition-shadow">
      <div class="db-content font-bold text-sm leading-snug text-gray-900 mb-1">{!! $article->issueTitle !!}</div>
      <div class="db-content italic text-forest-700 text-sm">{!! $article->issueAutor !!}</div>
      @if($article->issueFrom)
        <div class="db-content italic text-gray-500 text-xs mt-0.5">{!! $article->issueFrom !!}</div>
      @endif
      @if($article->issueSummary)
        <div class="db-content text-gray-600 text-xs mt-2 leading-relaxed">{!! $article->issueSummary !!}</div>
      @endif
      @if($article->issueFile)
        <div class="flex items-center justify-between mt-3 pt-2.5 border-t border-gray-100">
          <span class="text-gray-400 text-xs">
            @if($article->issueCount){{ $article->issueCount }} downloads@endif
          </span>
          <a href="{{ route('download.article', $article) }}"
             class="px-3 py-1.5 bg-forest-600 text-white rounded text-xs font-semibold hover:bg-forest-700 transition-colors">
            Download PDF
          </a>
        </div>
      @endif
    </div>
  @empty
    <p class="text-gray-500">No articles in this issue.</p>
  @endforelse
@endsection
