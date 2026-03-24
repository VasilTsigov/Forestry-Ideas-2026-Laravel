<?php

namespace App\Domains\Page\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscription';
    public $timestamps = false;

    protected $fillable = ['content'];
}
