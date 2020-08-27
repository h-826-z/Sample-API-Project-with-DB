<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    protected $fillable=['department_name'];
    
    public function positions()
    {
        return $this->hasMany('App\Position');
    }
    public function employees()
    {
        return $this->hasMany('App\Employee');
    }
    
}
