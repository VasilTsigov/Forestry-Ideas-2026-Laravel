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

  {{-- Article list --}}
  <div id="articles-list">
    @forelse($articles as $article)
      <div class="bg-white border border-gray-200 rounded-lg px-5 py-3 mb-2 hover:shadow-md transition-shadow">

        <div class="db-content font-bold uppercase text-base leading-snug text-gray-900">
          {!! $article->issueTitle !!}
        </div>

        <div class="db-content text-forest-700 text-sm font-semibold my-1.5">{!! $article->issueAutor !!}</div>

        @if($article->issueFrom)
          <div class="db-content text-gray-500 text-sm">{!! $article->issueFrom !!}</div>
        @endif

        <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-gray-100 text-xs">
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
          <div class="flex gap-2">
            @if($article->issueSummary)
              <button onclick="showDetail('detail-{{ $article->issueID }}')"
                      class="px-3 py-1.5 border border-forest-400 text-forest-600 rounded text-xs font-semibold hover:bg-forest-50 transition-colors">
                View
              </button>
            @endif
            @if($article->issueFile)
              <a href="{{ route('download.article', $article) }}"
                 class="inline-flex items-center gap-1 px-3 py-1.5 bg-forest-600 text-white rounded text-xs font-semibold hover:bg-forest-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17a2 2 0 002 2h14a2 2 0 002-2v-1" />
                </svg>
                PDF
              </a>
            @endif
          </div>
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
  </div>

  {{-- Article detail views --}}
  @foreach($articles as $article)
    @if($article->issueSummary)
      <div id="detail-{{ $article->issueID }}" class="hidden">

        <button onclick="backToList()"
                class="inline-flex items-center gap-1 text-xs text-forest-600 hover:text-forest-800 font-semibold mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
          Back to list
        </button>

        <div class="bg-white border border-gray-200 rounded-lg px-5 py-5">

          <div class="db-content font-bold uppercase text-base leading-snug text-gray-900">
            {!! $article->issueTitle !!}
          </div>

          <div class="db-content text-forest-700 text-sm font-semibold my-1.5">{!! $article->issueAutor !!}</div>

          @if($article->issueFrom)
            <div class="db-content text-gray-500 text-sm">{!! $article->issueFrom !!}</div>
          @endif

          <div class="db-content text-gray-600 text-sm mt-3 leading-relaxed border-t border-gray-100 pt-3">
            <span class="not-italic font-semibold text-[0.72rem] uppercase tracking-wide text-forest-600">Abstract: </span>
            {!! $article->issueSummary !!}
          </div>

          <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100 text-xs">
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
                 class="inline-flex items-center gap-1 px-3 py-1.5 bg-forest-600 text-white rounded text-xs font-semibold hover:bg-forest-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17a2 2 0 002 2h14a2 2 0 002-2v-1" />
                </svg>
                Download PDF
              </a>
            @endif
          </div>

        </div>
      </div>
    @endif
  @endforeach

  <script>
    function showDetail(id) {
      document.getElementById('articles-list').classList.add('hidden');
      document.querySelectorAll('[id^="detail-"]').forEach(el => el.classList.add('hidden'));
      document.getElementById(id).classList.remove('hidden');
      window.scrollTo(0, 0);
    }
    function backToList() {
      document.querySelectorAll('[id^="detail-"]').forEach(el => el.classList.add('hidden'));
      document.getElementById('articles-list').classList.remove('hidden');
    }
  </script>
@endsection
