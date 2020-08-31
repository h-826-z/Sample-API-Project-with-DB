<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/** * This model is  * *
    *  @author HZ
* * * @create date 28/08/2020 * */
class Position extends Model
{
    use SoftDeletes;
    //many to many relationship with department
    public function department()
    {
        
        return $this->belongsToMany('App\Department');
    }
}
