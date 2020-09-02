<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Http\Requests\EmployeeRegistrationValidationRequest;
use App\Repositories\Logics\EmployeeRegistrationLogic;
class EmployeeRegistrationController extends Controller
{
    public function __construct(EmployeeRepositoryInterface $employeeRepo,
                                EmployeeRegistrationLogic $emp_logic)
    {       
        $this->employeeRepo = $employeeRepo;
        $this->emp_logic = $emp_logic;

    }
    public function save(EmployeeRegistrationValidationRequest $request)
    {
        $this->employeeRepo->saveEmployee($request);
        $this->emp_logic->savePrepareData($request);
    }
}
