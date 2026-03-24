<?php

namespace App\Domains\Magazine\Models;

use App\Domains\Article\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Magazine extends Model
{
    protected $table = 'journal';
    protected $primaryKey = 'journalID';
    public $timestamps = false;

    protected $fillable = [
        'journalVolume',
        'journalNr',
        'journalYear',
        'journalTitle',
        'journalFile',
        'journalFileContent',
        'journalCount',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'issueJournalID', 'journalID');
    }
}
