<?php

namespace App\Http\Controllers;

use App\Domains\Page\Models\Home;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $homeContent = Home::first();

        return view('home', compact('homeContent'));
    }
}
