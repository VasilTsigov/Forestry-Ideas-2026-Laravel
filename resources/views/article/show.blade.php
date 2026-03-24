@extends('layouts.app')

@section('title', strip_tags($article->issueTitle) . ' — Forestry Ideas')
@section('page-title', strip_tags($article->issueTitle))

@section('content')
  @if($article->magazine)
    <p class="mb-4 text-sm">
      <a href="{{ route('magazine.show', $article->magazine->journalID) }}"
         class="font-semibold text-forest-600 hover:text-forest-800">
        &laquo; Back to issue
      </a>
    </p>
  @endif

  <div class="db-content italic font-semibold text-forest-700 mb-2">{!! $article->issueAutor !!}</div>

  @if($article->issueFrom)
    <div class="db-content italic text-gray-500 text-sm mb-3">{!! $article->issueFrom !!}</div>
  @endif

  @if($article->issueSummary)
    <p class="text-xs font-bold uppercase tracking-wide text-forest-600 mb-1">Abstract</p>
    <div class="db-content text-sm text-gray-700 leading-relaxed mb-4">{!! $article->issueSummary !!}</div>
  @endif

  @if($article->issueFile)
    <hr class="border-gray-200 my-4" />
    <div class="flex items-center gap-3">
      <a href="{{ route('download.article', $article) }}"
         class="inline-block px-4 py-2 bg-forest-600 text-white rounded font-semibold text-sm hover:bg-forest-700 transition-colors">
        Download full article (PDF)
      </a>
      @if($article->issueCount)
        <span class="text-gray-400 text-xs">{{ $article->issueCount }} downloads</span>
      @endif
    </div>
  @endif
@endsection
