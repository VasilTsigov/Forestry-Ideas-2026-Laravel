<?php

namespace App\Domains\Article\Models;

use App\Domains\Magazine\Models\Magazine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $table = 'issue';
    protected $primaryKey = 'issueID';
    public $timestamps = false;

    protected $fillable = [
        'issueTitle',
        'issueSummary',
        'issueAutor',
        'issueFrom',
        'issueFile',
        'issueJournalID',
        'issueCount',
    ];

    public function magazine(): BelongsTo
    {
        return $this->belongsTo(Magazine::class, 'issueJournalID', 'journalID');
    }
}
