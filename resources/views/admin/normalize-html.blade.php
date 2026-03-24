@extends('layouts.app')

@section('title', 'Normalize HTML — Admin')
@section('page-title', 'Normalize Article HTML')
@section('page-subtitle', 'Preview and apply HTML cleanup for article fields')

@section('content')
  @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-forest-100 border border-forest-300 text-forest-800 rounded text-sm font-semibold">
      {{ session('success') }}
    </div>
  @endif

  @if($total === 0)
    <p class="text-forest-700 font-semibold">Всички статии вече са с чист HTML — няма какво да се промени.</p>
  @else
    <div class="mb-5 flex items-center justify-between">
      <p class="text-sm text-gray-600">
        Намерени <strong>{{ $total }}</strong> полета с HTML за почистване.
        Ще се запазят само <code class="bg-gray-100 px-1 rounded">&lt;p&gt;</code>,
        <code class="bg-gray-100 px-1 rounded">&lt;br&gt;</code>,
        <code class="bg-gray-100 px-1 rounded">&lt;strong&gt;</code>,
        <code class="bg-gray-100 px-1 rounded">&lt;em&gt;</code>.
        Всички атрибути (<code class="bg-gray-100 px-1 rounded">style</code>,
        <code class="bg-gray-100 px-1 rounded">class</code> и др.) ще се премахнат.
      </p>

      <form method="POST" action="{{ route('admin.normalize-html.apply') }}"
            onsubmit="return confirm('Сигурен ли си? Промените в базата данни не могат лесно да се върнат.')">
        @csrf
        <button type="submit"
                class="px-5 py-2 bg-forest-600 text-white rounded font-semibold text-sm hover:bg-forest-700 transition-colors cursor-pointer border-0">
          Приложи промените
        </button>
      </form>
    </div>

    <div class="space-y-4">
      @foreach($preview as $item)
        <div class="bg-white border border-gray-200 rounded-lg p-4">
          <div class="flex items-baseline gap-3 mb-3">
            <span class="text-xs font-bold uppercase tracking-wide text-gray-400">#{{ $item['id'] }}</span>
            <span class="text-sm font-semibold text-gray-800 truncate flex-1">{{ $item['title'] }}</span>
            <span class="text-xs px-2 py-0.5 bg-forest-100 text-forest-700 rounded font-mono">{{ $item['field'] }}</span>
          </div>

          <div class="grid grid-cols-2 gap-3 text-xs">
            <div>
              <p class="font-semibold text-red-600 mb-1 uppercase tracking-wide">Преди</p>
              <div class="bg-red-50 border border-red-200 rounded p-2 font-mono text-gray-700 overflow-auto max-h-32 whitespace-pre-wrap break-all">{{ $item['before'] }}</div>
            </div>
            <div>
              <p class="font-semibold text-forest-700 mb-1 uppercase tracking-wide">След</p>
              <div class="bg-forest-50 border border-forest-200 rounded p-2 font-mono text-gray-700 overflow-auto max-h-32 whitespace-pre-wrap break-all">{{ $item['after'] }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-6 text-right">
      <form method="POST" action="{{ route('admin.normalize-html.apply') }}"
            onsubmit="return confirm('Сигурен ли си? Промените в базата данни не могат лесно да се върнат.')">
        @csrf
        <button type="submit"
                class="px-5 py-2 bg-forest-600 text-white rounded font-semibold text-sm hover:bg-forest-700 transition-colors cursor-pointer border-0">
          Приложи промените
        </button>
      </form>
    </div>
  @endif
@endsection
