<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/** * This model is  * *
    *  @author HZ
* * * @create date 26/08/2020 * */
class Position extends Model
{
    use SoftDeletes;
    /** *In one position can have many departments
     * * @author HZ
     * @create date 26/08/2020
     * @return Department Model
     * * */
    public function department()
    {
        
        return $this->belongsToMany('App\Department');
    }
}
