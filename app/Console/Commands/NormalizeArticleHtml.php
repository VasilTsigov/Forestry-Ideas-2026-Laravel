<?php

namespace App\Console\Commands;

use App\Domains\Article\Models\Article;
use Illuminate\Console\Command;

class NormalizeArticleHtml extends Command
{
    protected $signature = 'articles:normalize-html
                            {--dry-run : Preview changes without saving to the database}
                            {--field= : Process only a specific field (issueSummary, issueAutor, issueFrom, issueTitle)}';

    protected $description = 'Normalize HTML in article fields — keep only <p>, <br>, <strong>, <em>, strip all attributes and styles';

    private array $fields = ['issueSummary', 'issueAutor', 'issueFrom', 'issueTitle'];

    public function handle(): int
    {
        $dryRun  = $this->option('dry-run');
        $fields  = $this->option('field') ? [$this->option('field')] : $this->fields;
        $changed = 0;

        if ($dryRun) {
            $this->warn('DRY-RUN mode — no changes will be saved.');
            $this->newLine();
        }

        $articles = Article::all();
        $this->info("Processing {$articles->count()} articles...");
        $this->newLine();

        foreach ($articles as $article) {
            $dirty = false;

            foreach ($fields as $field) {
                if (empty($article->$field)) {
                    continue;
                }

                $original = $article->$field;
                $cleaned  = $this->cleanHtml($original);

                if ($cleaned === $original) {
                    continue;
                }

                $dirty = true;

                if ($dryRun) {
                    $this->line("<fg=yellow>Article #{$article->issueID} — {$field}:</>");
                    $this->line('  <fg=red>BEFORE:</> ' . $this->preview($original));
                    $this->line('  <fg=green>AFTER: </> ' . $this->preview($cleaned));
                    $this->newLine();
                } else {
                    $article->$field = $cleaned;
                }
            }

            if ($dirty && !$dryRun) {
                $article->save();
                $changed++;
            } elseif ($dirty) {
                $changed++;
            }
        }

        $action = $dryRun ? 'would be updated' : 'updated';
        $this->info("{$changed} articles {$action}.");

        return self::SUCCESS;
    }

    private function cleanHtml(string $html): string
    {
        // 1. Decode any double-encoded entities
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // 2. Strip all tags except the allowed set
        $html = strip_tags($html, '<p><br><strong><em>');

        // 3. Remove all attributes from remaining tags (strip style, class, id, etc.)
        $html = preg_replace('/<(p|strong|em)(\s[^>]*)>/i', '<$1>', $html);

        // 4. Normalise <br> variants to plain <br>
        $html = preg_replace('/<br\s*\/?>/i', '<br>', $html);

        // 5. Collapse multiple spaces/tabs inside the text (preserve newlines for now)
        $html = preg_replace('/[ \t]+/', ' ', $html);

        // 6. Remove empty paragraphs
        $html = preg_replace('/<p>\s*(<br>\s*)*<\/p>/i', '', $html);

        // 7. Trim leading/trailing whitespace
        $html = trim($html);

        return $html;
    }

    private function preview(string $html): string
    {
        $text = strip_tags($html);
        $text = preg_replace('/\s+/', ' ', trim($text));

        return mb_strlen($text) > 120 ? mb_substr($text, 0, 120) . '…' : $text;
    }
}
