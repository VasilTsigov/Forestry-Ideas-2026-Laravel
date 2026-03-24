@extends('layouts.app')

@section('title', 'Login — Forestry Ideas')
@section('page-title', 'Login')

@section('content')

  <form method="POST" action="{{ route('login') }}" class="space-y-3 max-w-sm">
    @csrf

    <div class="flex items-center gap-4">
      <label for="email" class="w-28 text-[0.85rem] text-gray-600 shrink-0">E-mail</label>
      <div class="flex-1">
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               class="w-full px-3 py-1.5 bg-forest-50 border border-forest-300 rounded text-sm focus:outline-none focus:border-forest-400 focus:bg-white transition-colors" />
        @error('email')<span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="flex items-center gap-4">
      <label for="password" class="w-28 text-[0.85rem] text-gray-600 shrink-0">Password</label>
      <div class="flex-1">
        <input type="password" name="password" id="password"
               class="w-full px-3 py-1.5 bg-forest-50 border border-forest-300 rounded text-sm focus:outline-none focus:border-forest-400 focus:bg-white transition-colors" />
      </div>
    </div>

    <div class="flex items-center gap-4">
      <div class="w-28 shrink-0"></div>
      <label class="flex items-center gap-2 text-[0.85rem] text-gray-600 cursor-pointer">
        <input type="checkbox" name="remember" value="1" class="accent-forest-600" />
        Remember me
      </label>
    </div>

    <div class="flex items-center gap-4">
      <div class="w-28 shrink-0"></div>
      <button type="submit"
              class="px-5 py-2 bg-forest-600 text-white rounded font-semibold text-[0.88rem] hover:bg-forest-800 transition-colors cursor-pointer border-0">
        Login
      </button>
    </div>
  </form>
@endsection
