<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['cells'];

    /**
     * Get the cells for the row.
     */
    public function cells()
    {
        return $this->hasMany('App\Models\Cell');
    }
}
