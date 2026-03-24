<?php

namespace App\Domains\News\Controllers;

use App\Domains\News\Models\News;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = News::orderByDesc('newsYear')
            ->orderByDesc('newsID')
            ->get();

        return view('news.index', compact('news'));
    }
}
