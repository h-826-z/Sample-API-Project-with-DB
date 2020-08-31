<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    protected $fillable=['department_name'];
    //many to many relationship with position
    public function positions()
    {
        return $this->hasMany('App\Position');
        

    }
    //many to many relationship with employees
    public function employees()
    {
        return $this->hasMany('App\Employee');
    }
    
   
    
}
