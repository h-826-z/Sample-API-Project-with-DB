<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepHasPosition extends Model
{
    public function positions()
    {
        return $this->hasMany('App\Position');
    }
}
