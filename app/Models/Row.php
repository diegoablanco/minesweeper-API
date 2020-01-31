<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    /**
     * Get the cells for the row.
     */
    public function cells()
    {
        return $this->hasMany('App\Models\Cell');
    }
}
