<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use  App\Http\Requests\EmployeeRegistrationValidationRequest;
use  App\Repositories\Logics\EmployeeRegistrationLogic;
class EmployeeRegistrationController extends Controller
{
    public function __construct(EmployeeRepositoryInterface $employeeRepo,
                                EmployeeRegistrationLogic $empLogic)
    {       
        $this->employeeRepo = $employeeRepo;
        $this->empLogic = $empLogic;

    }
    public function save(EmployeeRegistrationValidationRequest $request)
    {
        $this->employeeRepo->saveEmployee($request);
        $this->empLogic->savePrepareData($request);
    }
    public function update(EmployeeRegistrationValidationRequest $request)
    {
        $employee= $this->employeeRepo->checkEmployee($request);
        if($employee->isEmpty()){
            return response()->json([
                "Error:400" => "That employees doesn't exit! "
            ]);
        }else{
            $this->employeeRepo->updateEmployee($request);
            $this->empLogic->updatePrepareData($request);
        }
    }
}
