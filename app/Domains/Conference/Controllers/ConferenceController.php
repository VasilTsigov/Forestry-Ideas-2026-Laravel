<?php

namespace App\Domains\Conference\Controllers;

use App\Domains\Conference\Models\Conference;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ConferenceController extends Controller
{
    public function index(): View
    {
        $conferences = Conference::orderByDesc('confDate')->get();

        return view('conference.index', compact('conferences'));
    }
}
