<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Forestry Ideas — An International Journal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

{{-- Top bar --}}
<div class="bg-navy-900 text-navy-100 text-xs py-1.5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex justify-between items-center">
        <span>ISSN 1314-3905 (Print) &nbsp;·&nbsp; ISSN 2603-2996 (Online)</span>
        <span>University of Forestry, Sofia, Bulgaria</span>
    </div>
</div>

{{-- Navigation --}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/ltu-logo.png') }}" width="36" height="30" alt="LTU" class="opacity-90">
                <div>
                    <span class="block text-lg font-bold text-navy-800 leading-tight font-serif">Forestry Ideas</span>
                    <span class="block text-xs text-gray-500 leading-tight">An International Journal</span>
                </div>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-3 py-2 text-sm font-medium rounded transition-colors {{ request()->routeIs('home') ? 'text-forest-600 bg-forest-50' : 'text-gray-600 hover:text-navy-800 hover:bg-gray-50' }}">
                    Home
                </a>
                <a href="{{ route('magazine.index') }}"
                   class="px-3 py-2 text-sm font-medium rounded transition-colors {{ request()->routeIs('magazine.index') || request()->routeIs('magazine.show') ? 'text-forest-600 bg-forest-50' : 'text-gray-600 hover:text-navy-800 hover:bg-gray-50' }}">
                    Content
                </a>
                <a href="{{ route('magazine.issues') }}"
                   class="px-3 py-2 text-sm font-medium rounded transition-colors {{ request()->routeIs('magazine.issues') || request()->routeIs('article.*') ? 'text-forest-600 bg-forest-50' : 'text-gray-600 hover:text-navy-800 hover:bg-gray-50' }}">
                    Issues
                </a>
                <a href="{{ route('page.instructions-to-authors') }}"
                   class="px-3 py-2 text-sm font-medium rounded transition-colors {{ request()->routeIs('page.instructions-to-authors') ? 'text-forest-600 bg-forest-50' : 'text-gray-600 hover:text-navy-800 hover:bg-gray-50' }}">
                    Instructions
                </a>
                <a href="{{ route('conference.index') }}"
                   class="px-3 py-2 text-sm font-medium rounded transition-colors {{ request()->routeIs('conference.*') ? 'text-forest-600 bg-forest-50' : 'text-gray-600 hover:text-navy-800 hover:bg-gray-50' }}">
                    Conferences
                </a>
                <a href="{{ route('news.index') }}"
                   class="px-3 py-2 text-sm font-medium rounded transition-colors {{ request()->routeIs('news.*') ? 'text-forest-600 bg-forest-50' : 'text-gray-600 hover:text-navy-800 hover:bg-gray-50' }}">
                    News
                </a>
                <a href="{{ route('page.subscription') }}"
                   class="px-3 py-2 text-sm font-medium rounded transition-colors {{ request()->routeIs('page.subscription') ? 'text-forest-600 bg-forest-50' : 'text-gray-600 hover:text-navy-800 hover:bg-gray-50' }}">
                    Subscription
                </a>
                <a href="{{ route('page.publication-ethics') }}"
                   class="px-3 py-2 text-sm font-medium rounded transition-colors {{ request()->routeIs('page.publication-ethics') ? 'text-forest-600 bg-forest-50' : 'text-gray-600 hover:text-navy-800 hover:bg-gray-50' }}">
                    Publication Ethics
                </a>
            </nav>

            {{-- Mobile menu button --}}
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded text-gray-500 hover:bg-gray-100" aria-label="Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile nav --}}
    <div id="mobileMenu" class="hidden md:hidden border-t border-gray-100 bg-white px-4 pb-3">
        <div class="flex flex-col gap-1 pt-2">
            <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-50">Home</a>
            <a href="{{ route('magazine.index') }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-50">Content</a>
            <a href="{{ route('magazine.issues') }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-50">Issues</a>
            <a href="{{ route('page.instructions-to-authors') }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-50">Instructions</a>
            <a href="{{ route('conference.index') }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-50">Conferences</a>
            <a href="{{ route('news.index') }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-50">News</a>
            <a href="{{ route('page.subscription') }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-50">Subscription</a>
            <a href="{{ route('page.publication-ethics') }}" class="px-3 py-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-50">Publication Ethics</a>
        </div>
    </div>
</header>

{{-- Page hero --}}
@hasSection('hero')
    @yield('hero')
@else
    <div class="relative overflow-hidden text-white py-10"
         style="background: linear-gradient(to right, var(--color-navy-900) 0%, var(--color-navy-800) 38%, var(--color-navy-700) 65%, #52b788 100%);">

        {{-- Forest landscape silhouette --}}
        <div class="absolute inset-0 pointer-events-none select-none" aria-hidden="true">
            <svg class="absolute bottom-0 right-0 h-full"
                 style="width: 68%;
                        mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.2) 18%, rgba(0,0,0,0.55) 45%, black 78%);
                        -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.2) 18%, rgba(0,0,0,0.55) 45%, black 78%);"
                 viewBox="0 0 900 100"
                 preserveAspectRatio="xMaxYMax meet">

                {{-- Distant hills --}}
                <path fill="rgba(255,255,255,0.10)"
                      d="M0,100 L0,78 Q90,60 180,66 Q280,74 380,50 Q480,28 580,40 Q680,52 780,30 Q850,16 900,22 L900,100 Z"/>

                {{-- Background trees (smaller, lower opacity) --}}
                <path fill="rgba(255,255,255,0.16)" d="M 90,72 L 97,83 L 101,92 L 92,100 L 88,100 L 79,92 L 83,83 Z"/>
                <path fill="rgba(255,255,255,0.16)" d="M 165,58 L 174,73 L 180,87 L 167,100 L 163,100 L 150,87 L 156,73 Z"/>
                <path fill="rgba(255,255,255,0.16)" d="M 245,64 L 253,77 L 258,89 L 247,100 L 243,100 L 232,89 L 237,77 Z"/>

                {{-- Mid trees --}}
                <path fill="rgba(255,255,255,0.22)" d="M 330,45 L 342,66 L 349,83 L 333,100 L 327,100 L 311,83 L 318,66 Z"/>
                <path fill="rgba(255,255,255,0.22)" d="M 415,55 L 425,72 L 431,86 L 417,100 L 413,100 L 399,86 L 405,72 Z"/>
                <path fill="rgba(255,255,255,0.24)" d="M 498,35 L 512,59 L 520,79 L 501,100 L 495,100 L 476,79 L 484,59 Z"/>

                {{-- Foreground trees (taller, more opaque) --}}
                <path fill="rgba(255,255,255,0.28)" d="M 582,42 L 597,66 L 606,84 L 585,100 L 579,100 L 558,84 L 567,66 Z"/>
                <path fill="rgba(255,255,255,0.32)" d="M 668,18 L 686,50 L 697,75 L 671,100 L 665,100 L 639,75 L 650,50 Z"/>
                <path fill="rgba(255,255,255,0.32)" d="M 752,32 L 768,58 L 777,80 L 755,100 L 749,100 L 727,80 L 736,58 Z"/>
                <path fill="rgba(255,255,255,0.34)" d="M 840,25 L 857,54 L 867,78 L 843,100 L 837,100 L 813,78 L 823,54 Z"/>

            </svg>
        </div>

        {{-- Text content --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6">
            <h1 class="text-3xl font-bold font-serif">@yield('page-title', 'Forestry Ideas')</h1>
            @hasSection('page-subtitle')
                <p class="mt-1 text-navy-100 text-sm">@yield('page-subtitle')</p>
            @endif
        </div>
    </div>
@endif

{{-- Main content --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
    <div style="display:grid; grid-template-columns:minmax(0,1fr) 18rem; gap:2.5rem; align-items:start;">
        <aside style="grid-column:2; grid-row:1;">
            <div style="position:sticky; top:5.5rem;">
                @include('partials.sidebar')
            </div>
        </aside>
        <div style="grid-column:1; grid-row:1; min-width:0;">
            @yield('content')
        </div>
    </div>
</main>

{{-- Footer --}}
<footer class="bg-navy-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white font-semibold font-serif mb-3">Forestry Ideas</h3>
                <p class="text-sm leading-relaxed">
                    An International Journal published by the<br>
                    University of Forestry, Sofia, Bulgaria.
                </p>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-3">Contact</h3>
                <p class="text-sm leading-relaxed">
                    10 Kliment Ohridski blvd.<br>
                    1797 Sofia, Bulgaria<br>
                    Phone: +359 2 862 28 54<br>
                    <a href="mailto:ForestryIdeas@ltu.bg" class="text-forest-500 hover:text-forest-400">ForestryIdeas@ltu.bg</a>
                </p>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-3">Journal Info</h3>
                <p class="text-sm leading-relaxed">
                    ISSN 1314-3905 (Print)<br>
                    ISSN 2603-2996 (Online)
                </p>
                <div class="mt-4">
                    <a href="https://www.scimagojr.com/journalsearch.php?q=21100814514&tip=sid&exact=no"
                       target="_blank" title="SCImago Journal & Country Rank">
                        <img src="https://www.scimagojr.com/journal_img.php?id=21100814514"
                             width="120" height="79" alt="SCImago" class="opacity-90 hover:opacity-100 transition-opacity">
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-navy-700 mt-8 pt-6 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Forestry Ideas. All rights reserved.
        </div>
    </div>
</footer>

<script>
    document.getElementById('mobileMenuBtn').addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
</script>
@stack('scripts')
</body>
</html>
