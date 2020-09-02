<?php

namespace App\Repositories\Logics;

use Illuminate\Support\Facades\Config;
use App\Employee;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
use Illuminate\Support\Facades\Log;
/**
 * Class EmployeeRegistrationLogic.
 * @author HZ
 * @create date 02/09/2020
 */
class EmployeeRegistrationLogic
{
    public function __construct(EmployeeDepartmentPositionRepositoryInterface $emp_dep_pos)
    {
        $this->emp_dep_pos = $emp_dep_pos;
    }
    public function savePrepareData($request)
    {
        //take constant variable from config/constant.php
        //$default_position_id = Config::get('constant.default_department_id');
        //$default_department_id = Config::get('constant.default_department_id');
        if ($request->position_id) {
            $pos_id = $request->position_id;
        } else {
            $pos_id = 1;
        }
        if ($request->department_id) {
            $dep_id = $request->department_id;
        } else {
            $dep_id = 1;
        }
        $employeeId = Employee::max('id');
        Log::info($employeeId);
        //$this->emp_dep_pos->saveEmployeeDep($employeeId, $pos_id, $dep_id);
        dd('reach');
        return true;
    }
}
