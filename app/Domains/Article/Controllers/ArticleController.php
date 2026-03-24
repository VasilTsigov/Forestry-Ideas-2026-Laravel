<?php

namespace App\Domains\Article\Controllers;

use App\Domains\Article\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function show(Article $article): View
    {
        return view('article.show', compact('article'));
    }
}
