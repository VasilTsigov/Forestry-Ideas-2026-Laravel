@extends('layouts.app')

@section('title', 'Issues — Forestry Ideas')
@section('page-title', 'Issues')
@section('page-subtitle', 'Browse articles by issue')

@section('content')
  <form method="GET" action="{{ route('magazine.issues') }}" class="mb-6">
    <select name="journal" onchange="this.form.submit()"
            class="px-3 py-2 border border-gray-300 rounded bg-white text-sm text-gray-800 cursor-pointer min-w-90 focus:outline-none focus:border-forest-500">
      <option value="">Select issue...</option>
      @foreach($journals as $j)
        <option value="{{ $j->journalID }}"
          {{ $selectedJournal && $selectedJournal->journalID == $j->journalID ? 'selected' : '' }}>
          {{ $j->journalTitle }}, {{ $j->journalYear }}, Vol. {{ $j->journalVolume }}, No. {{ $j->journalNr }}
        </option>
      @endforeach
    </select>
  </form>

  @forelse($articles as $article)
    <div class="bg-white border border-gray-200 rounded-lg px-5 py-4 mb-3 hover:shadow-md transition-shadow">

      <div class="db-content font-bold uppercase text-sm leading-snug text-gray-900 mb-1">
        {!! $article->issueTitle !!}
      </div>

      <div class="db-content text-forest-700 text-sm">{!! $article->issueAutor !!}</div>

      @if($article->issueFrom)
        <div class="db-content text-gray-500 text-xs mt-0.5">{!! $article->issueFrom !!}</div>
      @endif

      @if($article->issueSummary)
        <div class="db-content italic text-gray-600 text-xs mt-2 leading-relaxed">
          <span class="not-italic font-semibold text-[0.72rem] uppercase tracking-wide text-forest-600">Abstract: </span>
          {!! $article->issueSummary !!}
        </div>
      @endif

      <div class="flex items-center justify-between mt-3 pt-2.5 border-t border-gray-100 text-xs">
        <div class="text-gray-400">
          @if($selectedJournal)
            {{ $selectedJournal->journalTitle }},
            {{ $selectedJournal->journalYear }},
            Vol. {{ $selectedJournal->journalVolume }},
            No. {{ $selectedJournal->journalNr }}
          @endif
          @if($article->issueCount)
            &mdash; {{ $article->issueCount }} downloads
          @endif
        </div>
        @if($article->issueFile)
          <a href="{{ route('download.article', $article) }}"
             class="px-3 py-1.5 bg-forest-600 text-white rounded text-xs font-semibold hover:bg-forest-700 transition-colors">
            Download PDF
          </a>
        @endif
      </div>

    </div>
  @empty
    <p class="text-gray-500">No issues.</p>
  @endforelse

  @if($articles->hasPages())
    <div class="mt-6">
      {{ $articles->appends(request()->query())->links() }}
    </div>
  @endif
@endsection
