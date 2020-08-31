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

/** *Here is Employee Controller to show,store,insert,update,delete,search employee data
 * * @author HZ
 * @create date 28/08/2020 * */
class EmployeeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //take constant variable from config/constant.php
        $per_page = Config::get('constants.per_page');

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
                'employee_name' => 'required|alpha|min:5|max:20',
                'email' => 'email|unique:employees',
                'dob' => 'date_format:Y-m-d|before:today',
                'password' => 'required|min:6',
                'department_id' => 'required',
                'position_id' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            //save data to employee table

            try {
                $employees = new Employee();
                $employees->employee_name = $request->employee_name;
                $employees->emil = $request->email;
                $employees->dob = $request->dob;
                $employees->password = $request->password;
                $employees->gender = $request->gender;
                $employees->save();

                //save dep_emp_pos id
                $lastemp_id = Employee::max('id');
                //take constant variable from config/constant.php
                $constant_id = Config::get('constants.constant_id');
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
                $emp_dep_pos = new EmpDepPosition();
                $emp_dep_pos->employee_id = $lastemp_id;
                $emp_dep_pos->department_id = $dep_id;
                $emp_dep_pos->position_id = $pos_id;
                $emp_dep_pos->save();

                if (validator()) {
                    Mail::raw('Your registration Successfully', function ($message) {
                        $message->subject('Registration Info')->from('bamawlhr@gmail.com')->to('heinzaw1999.mdy@gmail.com');
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
        $per_page = Config::get('constants.per_page');
        $employees = Employee::whereId($id)
            ->with('departments', 'positions')
            ->paginate($per_page);


        return $employees;
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
            $pos_id = 1;
        }
        if ($request->department_id) {
            $dep_id = $request->department_id;
        } else {
            $dep_id = 1;
        }
        $emp_dep_pos = EmpDepPosition::where('employee_id', $id)->firstOrFail();
        $emp_dep_pos->department_id = $dep_id;
        $emp_dep_pos->position_id = $pos_id;

        $emp_dep_pos->update();

        return $emp_dep_pos;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::whereId($id)->firstOrFail();
        $employee->delete();
    }
    public function fdelete($id)
    {
        try {
            $emp_dep_pos = EmpDepPosition::where('employee_id', $id)->firstOrFail();
            if ($emp_dep_pos) {
                //EmpDepPosition::where('employee_id',$id)->forcedelete();//or
                $emp_dep_pos->forcedelete();
            }

            $emp = Employee::whereId($id)->firstOrFail();
            if ($emp) {
                $emp->forcedelete();
            }
            return response()->json([
                "message" => "Deleted"
            ]);
        } catch (Exception $e) {
            return response($e->getMessage());
        }
    }
    public function search(Request $request)
    {

       /*Retrive data associated with id and name
        $empid = $request['id'];
        $empname = $request['employee_name'];


        $search=Employee::where('id', $empid)->orWhere('employee_name', $empname)->get();
        return $search;
        */

        $search_data=[];
        
        if($request->id)
        {
            $search_id = ['id', $request->id];
            array_push($search_data, $search_id);
        }

         if($request->employee_name)
        {
            $search_name=['employee_name','like',$request->employee_name.'%'];
            array_push($search_data, $search_name);
        }
        
        $perPage = Config::get('constants.per_page');
        //return response()->json(["ofgk"]); die();
        $employees=Employee::with(['departments','positions'])->withTrashed()->where($search_data)->paginate($perPage);
        return response()->json($employees,200);
   
    }
    
    /**
     * Export Employee Data as excel
     * @param  int  $id
     * @return Employee excel download file
     */
    public function export($id)
    {
        if ($id == 'all') {
            return Excel::download(new EmployeesExport, 'EmployeesList.xlsx');
        } elseif (Employee::whereId($id)->firstOrFail()) {

            return Excel::download(new EmployeeExport($id), 'EmployeeList.xlsx');
        }
    }
}
