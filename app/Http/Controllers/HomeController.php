<?php

namespace App\Http\Controllers;

use App\Domains\News\Models\News;
use App\Domains\Page\Models\Home;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $homeContent = Home::first();

        $latestNews = News::orderByDesc('newsYear')
            ->orderByDesc('newsID')
            ->limit(5)
            ->get();

        return view('home', compact('homeContent', 'latestNews'));
    }
}
