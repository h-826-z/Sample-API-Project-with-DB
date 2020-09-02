<?php

namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface 
{
    public function saveEmployee($request);
    public function checkEmployee($request);
    public function updateEmployee($request);
}