<?php

namespace App\Repositories;

use App\EmpDepPosition;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
use Exception;

/**
 * Class EmployeeRepository.
 */
class EmployeeDepartmentPositionRepository implements EmployeeDepartmentPositionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function saveEmployeeDep($employeeId, $pos_id, $dep_id)
    {
        $emp_dep_pos=new EmpDepPosition();
        $emp_dep_pos->employee_id=$employeeId;
        $emp_dep_pos->department_id=$dep_id;
        $emp_dep_pos->position_id=$pos_id;

        try {
            $emp_dep_pos->save();
            return true;
        } catch (Exception $e) {
            return false;
        }      
    }
}
