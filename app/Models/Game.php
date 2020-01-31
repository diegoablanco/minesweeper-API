<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['state'];
    const STARTED = 'started';
    const FINISHED = 'finished';
    const OVER = 'over';
    /**
     * Get the rows for the game.
     */
    public function rows()
    {
        return $this->hasMany('App\Models\Row');
    }
}
