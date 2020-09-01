<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/** *Here is Employee Model 
 * * @author HZ
 * @create date 27/08/2020
 * * */
class Employee extends Model
{
    use SoftDeletes;

    /** *One Employee can have many departments
     * * @author HZ
     * @create date 26/08/2020
     * @return Department Model
     * * */
    public function departments()
    {
        return $this->belongsToMany('App\Department', 'emp_dep_positions', 'employee_id', 'department_id');
    }
    
    /** *One Employeee can have many positions
     * * @author HZ
     * @create date 26/08/2020
     * @return Position Model
     * * */
    public function positions()
    {
        return $this->belongsToMany('App\Position', 'emp_dep_positions', 'employee_id', 'position_id');
    }
}
