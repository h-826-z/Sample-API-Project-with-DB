<?php

namespace App\Repositories\Interfaces;

interface EmployeeDepartmentPositionRepositoryInterface 
{
    public function saveEmployeeDep($employeeId, $posId, $depId);
    
    public function updateEmployeeDep($employeeId, $posId, $depId);
}