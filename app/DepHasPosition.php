<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepHasPosition extends Model
{
    use SoftDeletes;
    public function positions()
    {
        return $this->hasMany('App\Position');
    }
}
