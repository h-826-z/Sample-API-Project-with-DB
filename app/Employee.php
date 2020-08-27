<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    public function departments()
    {     
        return $this->belongsToMany('App\Department','emp_dep_positions','employee_id','department_id');
    }
    public function positions()
    {
        
        return $this->belongsToMany('App\Position','emp_dep_positions','employee_id','position_id');
    }
}
