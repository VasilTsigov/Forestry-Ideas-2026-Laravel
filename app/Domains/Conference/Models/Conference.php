<?php

namespace App\Domains\Conference\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $table = 'conferences';
    protected $primaryKey = 'confID';
    public $timestamps = false;

    protected $fillable = [
        'confTitle',
        'confFileName',
        'confDate',
    ];
}
