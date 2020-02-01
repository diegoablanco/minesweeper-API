<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cell extends Model
{
    protected $fillable = ['is_bomb', 'neighbouring_bombs', 'state'];
    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['state', 'neighbouring_bombs'];

    const UNREVEALED = 'unrev';
    const REVEALED = 'rev';
    const FLAGGED = 'flagged';
    const QUESTION = 'question';
}
