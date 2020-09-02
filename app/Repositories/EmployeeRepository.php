<?php

namespace App\Repositories;

use App\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Exception;

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
}
