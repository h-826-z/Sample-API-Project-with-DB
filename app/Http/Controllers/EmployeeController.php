<?php

namespace App\Http\Controllers;

use App\EmpDepPosition;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees=Employee::all();
        return $employees;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $employees=new Employee();
       $employees->employee_name = $request->employee_name;
       $employees->email = $request->email;
       $employees->dob =$request->dob;
       $employees->password = $request->password;
       $employees->gender = $request->gender;
       $employees->save();

        //save dep_emp_pos id
        $lastemp_id=Employee::max('id');
        if($request->position_id){
            $pos_id=$request->position_id;
        }else{
            $pos_id=1;
        }
        if($request->department_id){
            $dep_id=$request->department_id;
        }else{
            $dep_id=1;
        }
        $emp_dep_pos=new EmpDepPosition();
        $emp_dep_pos->employee_id =$lastemp_id;
        $emp_dep_pos->department_id = $dep_id;
        $emp_dep_pos->position_id = $pos_id;
        $emp_dep_pos->save();


       return $employees;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employees=Employee::find($id);
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
    public function update(Request $request,$id)
    {
        $employees=Employee::find($id);
        $employees->employee_name = $request->employee_name;
        $employees->email = $request->email;
        $employees->dob =$request->dob;
        $employees->password = $request->password;
        $employees->gender = $request->gender;
        $employees->update();
        
        //save dep_emp_pos id
        if($request->position_id){
            $pos_id=$request->position_id;     
        }else{
            $pos_id=1;
        }
        if($request->department_id){
            $dep_id=$request->department_id;
        }else{
            $dep_id=1;
        }
        $emp_dep_pos=EmpDepPosition::where('employee_id',$id)->firstOrFail();
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
        //
    }
}
