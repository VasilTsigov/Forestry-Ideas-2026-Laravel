<?php

namespace App\Domains\Page\Models;

use Illuminate\Database\Eloquent\Model;

class PublicationEthics extends Model
{
    protected $table = 'pub_ethics';
    public $timestamps = false;

    protected $fillable = ['content'];
}
