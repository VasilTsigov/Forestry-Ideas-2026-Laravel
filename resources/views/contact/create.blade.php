@extends('layouts.app')

@section('title', 'Contacts — Forestry Ideas')
@section('page-title', 'Contacts')

@section('content')
  @if(session('success'))
    <p class="text-forest-700 font-semibold mb-4">{{ session('success') }}</p>
  @endif

  <form method="POST" action="{{ route('contact.store') }}" class="space-y-3 max-w-md">
    @csrf

    <div class="flex items-start gap-4">
      <label for="name" class="w-28 pt-2 text-sm text-gray-600 shrink-0">Name *</label>
      <div class="flex-1">
        <input type="text" name="name" id="name" value="{{ old('name') }}"
               class="w-full px-3 py-1.5 bg-gray-50 border border-gray-300 rounded text-sm focus:outline-none focus:border-forest-500 focus:bg-white transition-colors" />
        @error('name')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="flex items-start gap-4">
      <label for="email" class="w-28 pt-2 text-sm text-gray-600 shrink-0">E-mail *</label>
      <div class="flex-1">
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               class="w-full px-3 py-1.5 bg-gray-50 border border-gray-300 rounded text-sm focus:outline-none focus:border-forest-500 focus:bg-white transition-colors" />
        @error('email')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="flex items-start gap-4">
      <label for="phone" class="w-28 pt-2 text-sm text-gray-600 shrink-0">Phone</label>
      <div class="flex-1">
        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
               class="w-full px-3 py-1.5 bg-gray-50 border border-gray-300 rounded text-sm focus:outline-none focus:border-forest-500 focus:bg-white transition-colors" />
      </div>
    </div>

    <div class="flex items-start gap-4">
      <label for="subject" class="w-28 pt-2 text-sm text-gray-600 shrink-0">Subject *</label>
      <div class="flex-1">
        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
               class="w-full px-3 py-1.5 bg-gray-50 border border-gray-300 rounded text-sm focus:outline-none focus:border-forest-500 focus:bg-white transition-colors" />
        @error('subject')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="flex items-start gap-4">
      <label for="message" class="w-28 pt-2 text-sm text-gray-600 shrink-0">Message *</label>
      <div class="flex-1">
        <textarea name="message" id="message" rows="7"
                  class="w-full px-3 py-1.5 bg-gray-50 border border-gray-300 rounded text-sm focus:outline-none focus:border-forest-500 focus:bg-white transition-colors resize-y">{{ old('message') }}</textarea>
        @error('message')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="flex items-start gap-4">
      <div class="w-28 shrink-0"></div>
      <button type="submit"
              class="px-5 py-2 bg-forest-600 text-white rounded font-semibold text-sm hover:bg-forest-700 transition-colors cursor-pointer border-0">
        Send
      </button>
    </div>
  </form>
@endsection
