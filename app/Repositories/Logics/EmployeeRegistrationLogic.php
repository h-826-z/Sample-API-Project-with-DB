<?php

namespace App\Repositories\Logics;

use App\Employee;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
/**
 * Class EmployeeRegistrationLogic.
 * @author HZ
 * @create date 02/09/2020
 */
class EmployeeRegistrationLogic
{
    public function __construct(EmployeeDepartmentPositionRepositoryInterface $empDepPos)
    {
        $this->empDepPos = $empDepPos;
    }
    public function savePrepareData($request)
    {
        if ($request->position_id) {
            $posId = $request->position_id;
        } else {
            $posId = 1;
        }
        if ($request->department_id) {
            $depId = $request->department_id;
        } else {
            $depId = 1;
        }
        $employeeId = Employee::max('id');
        //Log::info($employeeId);
        $this->empDepPos->saveEmployeeDep($employeeId, $posId, $depId);
        //dd('reach');
        return true;
    }
    public function updatePrepareData($request)
    {
        if ($request->position_id) {
            $posId = $request->position_id;
        } else {
            $posId = 1;
        }
        if ($request->department_id) {
            $depId = $request->department_id;
        } else {
            $depId = 1;
        }
        $employeeId = $request->id;
        $this->empDepPos->updateEmployeeDep($employeeId, $posId, $depId);
        return true;
    }
}
