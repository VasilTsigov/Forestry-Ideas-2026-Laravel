<?php

use App\Domains\Admin\Controllers\NormalizeHtmlController;
use App\Domains\Article\Controllers\ArticleController;
use App\Domains\Download\Controllers\DownloadController;
use App\Domains\Conference\Controllers\ConferenceController;
use App\Domains\Contact\Controllers\ContactController;
use App\Domains\Magazine\Controllers\MagazineController;
use App\Domains\News\Controllers\NewsController;
use App\Domains\Page\Controllers\PageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contents — list of journals with download buttons
Route::get('/journal', [MagazineController::class, 'index'])->name('magazine.index');
Route::get('/journal/{magazine}', [MagazineController::class, 'show'])->name('magazine.show');

// Issues — all articles with journal filter
Route::get('/issues', [MagazineController::class, 'issues'])->name('magazine.issues');

// Downloads (served from storage, not public)
Route::get('/download/article/{article}', [DownloadController::class, 'article'])->name('download.article');
Route::get('/download/journal/{magazine}', [DownloadController::class, 'journal'])->name('download.journal');
Route::get('/download/journal-content/{magazine}', [DownloadController::class, 'journalContent'])->name('download.journal-content');
Route::get('/download/conference/{id}', [DownloadController::class, 'conference'])->name('download.conference');

// Articles
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('article.show');

// News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

// Conferences
Route::get('/conferences', [ConferenceController::class, 'index'])->name('conference.index');

// Static pages
Route::get('/publication-ethics', [PageController::class, 'publicationEthics'])->name('page.publication-ethics');
Route::get('/subscription', [PageController::class, 'subscription'])->name('page.subscription');
Route::get('/instructions-to-authors', [PageController::class, 'instructionsToAuthors'])->name('page.instructions-to-authors');

// Contact
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin (no auth yet — to be added when admin panel is developed)
Route::get('/admin/normalize-html', [NormalizeHtmlController::class, 'index'])->name('admin.normalize-html');
Route::post('/admin/normalize-html', [NormalizeHtmlController::class, 'apply'])->name('admin.normalize-html.apply');

Route::get('/admin/diagnostics', function () {
    $fields = ['issueTitle', 'issueSummary', 'issueAutor', 'issueFrom'];
    $results = [];

    foreach ($fields as $field) {
        $hits = \App\Domains\Article\Models\Article::where($field, 'like', '%Ginger%')
            ->orWhere($field, 'like', '%Rephrase%')
            ->orWhere($field, 'like', '%Disable in this text field%')
            ->get(['issueID', 'issueTitle', $field]);

        foreach ($hits as $article) {
            $results[] = [
                'id'    => $article->issueID,
                'title' => strip_tags($article->issueTitle ?? ''),
                'field' => $field,
                'value' => $article->$field,
            ];
        }
    }

    if (empty($results)) {
        return '<p style="font-family:sans-serif;padding:2rem;color:green;font-size:1.2rem">
            ✅ Няма следи от Ginger в базата данни. Всичко е чисто.
        </p>';
    }

    $html = '<style>body{font-family:sans-serif;padding:2rem} table{border-collapse:collapse;width:100%} td,th{border:1px solid #ccc;padding:8px;text-align:left;vertical-align:top} th{background:#f5f5f5}</style>';
    $html .= '<h2>Намерени ' . count($results) . ' записа с Ginger текст</h2>';
    $html .= '<table><tr><th>#</th><th>Статия</th><th>Поле</th><th>Съдържание</th></tr>';
    foreach ($results as $r) {
        $html .= "<tr><td>{$r['id']}</td><td>" . htmlspecialchars(mb_substr($r['title'], 0, 60)) . "</td><td>{$r['field']}</td><td style='font-size:0.8rem;max-width:500px;word-break:break-all'>" . htmlspecialchars(mb_substr($r['value'], 0, 300)) . '</td></tr>';
    }
    $html .= '</table>';

    return $html;
})->name('admin.diagnostics');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'create'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store']);
});

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
