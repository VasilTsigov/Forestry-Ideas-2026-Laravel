<?php

namespace App\Domains\Download\Controllers;

use App\Domains\Article\Models\Article;
use App\Domains\Magazine\Models\Magazine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
    /**
     * Download a single article PDF and increment its counter.
     */
    public function article(Article $article): BinaryFileResponse
    {
        abort_unless($article->issueFile, 404);

        $path = storage_path('app/files/issue/' . $article->issueFile);

        abort_unless(file_exists($path), 404);

        $article->increment('issueCount');

        return response()->download($path, $article->issueFile, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Download a full journal issue PDF and increment its counter.
     */
    public function journal(Magazine $magazine): BinaryFileResponse
    {
        abort_unless($magazine->journalFile, 404);

        $path = storage_path('app/files/journal/' . $magazine->journalFile);

        abort_unless(file_exists($path), 404);

        $magazine->increment('journalCount');

        return response()->download($path, $magazine->journalFile, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Download a conference PDF.
     */
    public function conference(int $id): BinaryFileResponse
    {
        $conference = \App\Domains\Conference\Models\Conference::findOrFail($id);

        abort_unless($conference->confFileName, 404);

        $path = storage_path('app/files/issue/' . $conference->confFileName);

        abort_unless(file_exists($path), 404);

        return response()->download($path, $conference->confFileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
