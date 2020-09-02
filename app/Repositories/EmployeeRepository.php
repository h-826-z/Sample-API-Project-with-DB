<?php

namespace App\Repositories;

use App\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class EmployeeRepository.
 * @author HZ
 * @create date 02/09/2020
 */
class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @author HZ
     * @return Return the model
     * @create date 02/09/2020
     */
    public function saveEmployee($request)
    {
        $employees=new Employee();
        $employees->employee_name=$request->employee_name;
        $employees->email=$request->email;
        $employees->dob=$request->dob;
        $employees->password=$request->password;
        $employees->gender=$request->gender;

        try {
            $employees->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
        
    }
    public function checkEmployee($request)
    {
        $employeeId=$request->id;
        $employee= DB::table('employees')
                    ->leftJoin('emp_dep_positions','employees.id','=','emp_dep_positions.employee_id')
                    ->where('employees.id',$employeeId)
                    ->get();
        
        return $employee;  
    }
    public function updateEmployee($request)
    {
        try {
        $employeeId=$request->id;
        $employeeName=$request->employee_name;
        $employeeEmail=$request->email;
        $employeeDob=$request->dob;
        $employeePwd=$request->password;
        $employeeGender=$request->gender;
        DB::table('employees')
            ->where('id',$employeeId)
            ->update([
                'employee_name' => $employeeName,
                'email' => $employeeEmail,
                'dob' => $employeeDob,
                'password' => $employeePwd,
                'gender' => $employeeGender
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
        
    }
    
}
