<?php

namespace App\Repositories;

use App\EmpDepPosition;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class EmployeeRepository.
 */
class EmployeeDepartmentPositionRepository implements EmployeeDepartmentPositionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function saveEmployeeDep($employeeId, $posId, $depId)
    {
        $emp_dep_pos = new EmpDepPosition();
        $emp_dep_pos->employee_id = $employeeId;
        $emp_dep_pos->department_id = $depId;
        $emp_dep_pos->position_id = $posId;

        try {
            $emp_dep_pos->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateEmployeeDep($employeeId, $posId, $depId)
    {
        try {
            $depEmpPos=DB::table('emp_dep_positions')
                ->where('employee_id', $employeeId)
                ->update([
                    'department_id' => $depId,
                    'position_id' => $posId
                ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
