<?php

namespace App\Domains\News\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news_en';
    protected $primaryKey = 'newsID';
    public $timestamps = false;

    protected $fillable = [
        'newsDatum',
        'newsYear',
        'newsText',
    ];
}
