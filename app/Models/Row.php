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
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['cells'];

    /**
     * Get the cells for the row.
     */
    public function cells()
    {
        return $this->hasMany('App\Models\Cell');
    }
}
