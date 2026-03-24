<?php

namespace App\Domains\Page\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table = 'home';
    protected $primaryKey = 'homeID';
    public $timestamps = false;

    protected $fillable = ['homeText'];
}
