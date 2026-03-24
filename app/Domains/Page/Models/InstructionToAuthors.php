<?php

namespace App\Domains\Page\Models;

use Illuminate\Database\Eloquent\Model;

class InstructionToAuthors extends Model
{
    protected $table = 'instr_to_autors';
    protected $primaryKey = 'instrID';
    public $timestamps = false;

    protected $fillable = ['instrText'];
}
