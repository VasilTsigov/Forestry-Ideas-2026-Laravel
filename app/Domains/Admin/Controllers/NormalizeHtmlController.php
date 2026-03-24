<?php

namespace App\Domains\Admin\Controllers;

use App\Domains\Article\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

class NormalizeHtmlController extends Controller
{
    private array $fields = ['issueSummary', 'issueAutor', 'issueFrom', 'issueTitle'];

    public function index(): View
    {
        $preview = $this->buildPreview();

        return view('admin.normalize-html', [
            'preview' => $preview,
            'total'   => count($preview),
        ]);
    }

    public function apply(): RedirectResponse
    {
        $count  = 0;
        $errors = 0;

        foreach (Article::all() as $article) {
            $dirty = false;

            foreach ($this->fields as $field) {
                if (empty($article->$field)) {
                    continue;
                }

                $original = $article->$field;
                $cleaned  = $this->cleanHtml($original);

                // Skip if cleaning produced empty result for a non-empty field
                if (empty($cleaned)) {
                    continue;
                }

                if ($cleaned !== $original) {
                    $article->$field = $cleaned;
                    $dirty = true;
                }
            }

            if ($dirty) {
                try {
                    $article->save();
                    $count++;
                } catch (\Throwable $e) {
                    $errors++;
                    // Capture first error for diagnostics
                    if ($errors === 1) {
                        $firstError = "Article #{$article->issueID}: " . $e->getMessage();
                    }
                }
            }
        }

        $msg = "Обновени {$count} статии.";
        if ($errors > 0) {
            $msg .= " ({$errors} пропуснати). Грешка: " . ($firstError ?? 'unknown');
        }

        return redirect()->route('admin.normalize-html')->with('success', $msg);
    }

    private function buildPreview(): array
    {
        $changes = [];

        foreach (Article::all() as $article) {
            foreach ($this->fields as $field) {
                if (empty($article->$field)) {
                    continue;
                }

                $cleaned = $this->cleanHtml($article->$field);

                if ($cleaned !== $article->$field) {
                    $changes[] = [
                        'id'     => $article->issueID,
                        'title'  => strip_tags($article->issueTitle ?? ''),
                        'field'  => $field,
                        'before' => $article->$field,
                        'after'  => $cleaned,
                    ];
                }
            }
        }

        return $changes;
    }

    private function cleanHtml(string $original): string
    {
        $html = $original;

        // 1. Decode entities
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // 2. Remove Ginger browser extension injected text
        $html = $this->removeGingerText($html);

        // 3. Convert common block-level tags to newlines before stripping
        $html = preg_replace('/<\/?(div|li|tr|td|th|h[1-6])[^>]*>/i', "\n", $html) ?? $html;

        // 4. Strip all tags except allowed
        $html = strip_tags($html, '<p><br><strong><em>');

        // 5. Remove all attributes from allowed tags
        $html = preg_replace('/<(p|strong|em)\s[^>]*>/i', '<$1>', $html) ?? $html;

        // 6. Normalise <br> variants to newline for paragraph detection
        $html = preg_replace('/<br\s*\/?>/i', "\n", $html) ?? $html;

        // 7. Collapse spaces/tabs but preserve newlines
        $html = preg_replace('/[ \t]+/', ' ', $html) ?? $html;

        // 8. Wrap in paragraphs if no <p> tags present
        if (!preg_match('/<p[\s>]/i', $html)) {
            $html = $this->wrapInParagraphs($html);
        } else {
            $html = preg_replace('/\n/', '<br>', $html) ?? $html;
        }

        // 9. Remove empty paragraphs
        $html = preg_replace('/<p>\s*(<br>\s*)*<\/p>/i', '', $html) ?? $html;

        $result = trim($html);

        // Safety: if cleaning produced empty string, return original
        return $result !== '' ? $result : $original;
    }

    private function wrapInParagraphs(string $html): string
    {
        // Split on two or more consecutive newlines → paragraph break
        $paragraphs = preg_split('/\n{2,}/', $html);

        $result = '';
        foreach ($paragraphs as $para) {
            // Single newlines within a paragraph become <br>
            $para = preg_replace('/\n/', '<br>', trim($para));
            $para = trim($para);
            if ($para !== '') {
                $result .= '<p>' . $para . '</p>';
            }
        }

        // If no double newlines found, wrap the whole thing in one <p>
        if ($result === '') {
            $text = preg_replace('/\n/', '<br>', trim($html));
            $result = '<p>' . $text . '</p>';
        }

        return $result;
    }

    private function removeGingerText(string $html): string
    {
        // Remove Ginger extension HTML elements (safe non-backtracking patterns)
        $html = preg_replace('/<[^>]*ginger[^>]*>[^<]*<\/[^>]+>/i', '', $html) ?? $html;
        $html = preg_replace('/<[^>]*ginger[^>]*\/?>/i', '', $html) ?? $html;

        // Remove known Ginger UI text strings (longest/most specific first)
        $gingerStrings = [
            'Enable GingerCannot connect to Ginger Check your internet connection or reload the browserDisable in this text fieldRephraseRephrase current sentenceEdit in Ginger',
            'Rephrase current sentence',
            'Edit in Ginger',
            'Enable Ginger',
            'Cannot connect to Ginger',
            'Check your internet connection',
            'or reload the browser',
            'Disable in this text field',
            'Rephrase×',
            'Rephrase',
        ];

        foreach ($gingerStrings as $str) {
            $html = str_replace($str, '', $html);
        }

        // Remove any remaining × (Ginger close button)
        $html = str_replace('×', '', $html);

        return $html;
    }
}
