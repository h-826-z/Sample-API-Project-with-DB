<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/** *Here is Department Model 
 * * @author HZ
 * @create date 27/08/2020
 * * */
class Department extends Model
{
    use SoftDeletes;
    protected $fillable=['department_name'];

    /** *In one department can have many positions
     * * @author HZ
     * @create date 26/08/2020
     * @return Position Model
     * * */
    public function positions()
    {
        return $this->hasMany('App\Position');
        

    }
    /** *In one department can have many employees
     * * @author HZ
     * @create date 26/08/2020
     * @return Employee Model
     * * */
    public function employees()
    {
        return $this->hasMany('App\Employee');
    }
    
   
    
}
