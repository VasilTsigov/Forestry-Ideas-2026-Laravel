<?php

namespace App\Domains\Magazine\Controllers;

use App\Domains\Article\Models\Article;
use App\Domains\Magazine\Models\Magazine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MagazineController extends Controller
{
    public function index(): View
    {
        $magazines = Magazine::withCount('articles')
            ->has('articles')
            ->orderByDesc('journalYear')
            ->orderByDesc('journalID')
            ->get();

        return view('magazine.index', compact('magazines'));
    }

    public function show(Magazine $magazine): View
    {
        $magazine->load('articles');

        return view('magazine.show', compact('magazine'));
    }

    public function issues(Request $request): View
    {
        $journals = Magazine::withCount('articles')
            ->has('articles')
            ->orderByDesc('journalYear')
            ->orderByDesc('journalID')
            ->get();

        $selectedJournal = null;
        $articles = collect();

        if ($request->filled('journal')) {
            $selectedJournal = Magazine::find($request->journal);
            if ($selectedJournal) {
                $articles = Article::where('issueJournalID', $selectedJournal->journalID)
                    ->orderBy('issueID')
                    ->paginate(10);
            }
        } else {
            // По подразбиране — последния брой
            $selectedJournal = $journals->first();
            if ($selectedJournal) {
                $articles = Article::where('issueJournalID', $selectedJournal->journalID)
                    ->orderBy('issueID')
                    ->paginate(10);
            }
        }

        return view('magazine.issues', compact('journals', 'selectedJournal', 'articles'));
    }
}
