<?php

namespace App\Domains\Page\Controllers;

use App\Domains\Page\Models\InstructionToAuthors;
use App\Domains\Page\Models\PublicationEthics;
use App\Domains\Page\Models\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function publicationEthics(): View
    {
        $page = PublicationEthics::firstOrFail();

        return view('page.publication-ethics', compact('page'));
    }

    public function subscription(): View
    {
        $page = Subscription::firstOrFail();

        return view('page.subscription', compact('page'));
    }

    public function instructionsToAuthors(): View
    {
        $page = InstructionToAuthors::firstOrFail();

        return view('page.instructions-to-authors', compact('page'));
    }
}
