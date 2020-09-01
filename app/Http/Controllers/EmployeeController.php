<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\DepHasPosition;
use App\EmpDepPosition;
use App\Employee;
use App\Exports\EmployeeExport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\EmployeesExport;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Constraint\IsEqual;

/** *Here is Employee Controller to show,store,insert,update,delete,search employee data
 * * @author HZ
 * @create date 28/08/2020 * */
class EmployeeController extends Controller
{

    /**
     * Display a listing of the resource.
     *@author HZ
     * @return \Illuminate\Http\Response
     * 
     */
    public function index()
    {

        //take constant variable from config/constant.php
        $per_page = Config::get('constant.per_page');

        $employees = Employee::with('departments', 'positions')->paginate($per_page);
        return response($employees, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'employee_name' => 'required|min:5|max:20',
                'email' => 'email|unique:employees',
                'dob' => 'date_format:Y-m-d|before:today',
                'password' => 'required|min:6'
                //'department_id' => 'required',
                //'position_id' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            //save data to employee table

            try {
                $employees = new Employee();
                $employees->employee_name = $request->employee_name;
                $employees->email = $request->email;
                $employees->dob = $request->dob;
                $employees->password = $request->password;
                $employees->gender = $request->gender;
                $employees->save();

                //save dep_emp_pos id
                $lastemp_id = Employee::max('id');
                //take constant variable from config/constant.php
                $default_position_id = Config::get('constant.default_position_id');
                //take constant variable from config/constant.php
                $default_department_id = Config::get('constant.default_department_id');
                if ($request->position_id) {
                    $pos_id = $request->position_id;
                } else {
                    $pos_id = $default_position_id;
                }
                if ($request->department_id) {
                    $dep_id = $request->department_id;
                } else {
                    $dep_id = $default_department_id;
                }
                $emp_dep_pos = new EmpDepPosition();
                $emp_dep_pos->employee_id = $lastemp_id;
                $emp_dep_pos->department_id = $dep_id;
                $emp_dep_pos->position_id = $pos_id;
                $emp_dep_pos->save();

                if (validator()) {
                    Mail::raw('Your registration Successfully', function ($message) {
                        $message->subject('Registration Info')->from('bamawlhr@gmail.com')->to('chozinchozin560@gmail.com');
                    });
                }
                return response()->json([
                    "Message" => "Registration Successfully"
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    "Error" => "500 Internal Server Error"
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $per_page = Config::get('constant.per_page');

        $employees = Employee::whereId($id)
            ->with('departments', 'positions')->paginate($per_page);

        if ($employees) {
            return response()->json($employees, 200);
        } else {
            return response()->json([
                "Error: 400" => "Bad Input Request"
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //take constant variable from config/constant.php
        $constant_id = Config::get('constants.constant_id');

        $employees = Employee::find($id);
        $employees->employee_name = $request->employee_name;
        $employees->email = $request->email;
        $employees->dob = $request->dob;
        $employees->password = $request->password;
        $employees->gender = $request->gender;
        $employees->update();

        //save dep_emp_pos id
        if ($request->position_id) {
            $pos_id = $request->position_id;
        } else {
            $pos_id = $constant_id;
        }
        if ($request->department_id) {
            $dep_id = $request->department_id;
        } else {
            $dep_id = $constant_id;
        }
        $emp_dep_pos = EmpDepPosition::where('employee_id', $id)->first();
        $emp_dep_pos->department_id = $dep_id;
        $emp_dep_pos->position_id = $pos_id;

        $emp_dep_pos->update();

        return response()->json($emp_dep_pos, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::whereId($id)->first();
        $emp_dep_pos = EmpDepPosition::where('employee_id', $id)->first();


        if ($emp_dep_pos && $employee) {
            if ($emp_dep_pos) {
                $emp_dep_pos->delete();
            }
            if ($employee) {
                $employee->delete();
            }
            return response()->json([
                "Message" => "Delete success"
            ], 200);
        } else {
            return response()->json([
                "Error: 400" => "Bad Input Request"
            ], 400);
        }
    }
    /**
     * Search Employee Data
     * @param  $id
     * @author HZ
     * @return Json message
     * @create date 31/08/2020
     */
    public function fdelete($id)
    {
        try {
            $emp_dep_pos = EmpDepPosition::where('employee_id', $id)->withTrashed()->first();
            $employee = Employee::whereId($id)->withTrashed()->first();
            if ($emp_dep_pos && $employee) { //check whether search id has in emp_dep_pos and employee tables or not
                if ($emp_dep_pos) {
                    $emp_dep_pos->forcedelete();
                }
                if ($employee) {
                    $employee->forcedelete();
                }
                return response()->json([
                    "message" => "Deleted"
                ], 200);
            } else {
                return response()->json([
                    "Error" => "Id not found!"
                ], 400);
            }
        } catch (Exception $e) {
            return response($e->getMessage());
        }
    }
    /**
     * Search Employee Data
     * @param  Request  $request
     * @author HZ
     * @return Employee Data
     * @create date 31/08/2020
     */
    public function search(Request $request)
    {
        //take constant variable from config/constant.php
        $per_page = Config::get('constant.per_page');
        $search_data = [];

        if ($request->employee_id) { //search with id is true
            $search_id = ['id', $request->employee_id];
            array_push($search_data, $search_id); //put id to $search_data array
        }
        if ($request->employee_name) { //search with name is true
            $search_name = ['employee_name', 'like', $request->employee_name . '%'];
            array_push($search_data, $search_name);
        }

        $employees = Employee::with(['departments', 'positions'])
            ->withTrashed()
            ->where($search_data)
            ->paginate($per_page);
        if ($employees) {
            return response()->json($employees, 200);
        } else {
            return response()->json([
                "Error:400" => "Bad Input Request"
            ], 400);
        }
    }

    /**
     * Export Employee Data as excel
     * @param  int  $id
     * @author HZ
     * @return Employee excel download file
     * @create date 31/08/2020
     */
    public function export(Request $request)
    {      
        return Excel::download(new EmployeesExport($request->id), 'EmployeeList.xlsx');  
    }
}
