<?php

namespace App\Http\Controllers;

use App\Department;
use App\DepHasPosition;
use App\EmpDepPosition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** *Here is Department Controller to show,store,insert,update,delete,search data
 * * @author HZ
 * @create date 27/08/2020
 * * */
class DepartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $department = Department::all();
            return response($department, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "Error:500" => "Internal Server Error!"
            ], 500);
        }
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
     * @author HZ
     * @return department Data
     * @create date 29/08/2020
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'department_name' => 'required|min:5|max:20',
            ]
        );
        if ($validator->fails()) { //if validation fail is true
            return response()->json($validator->errors(), 400); //show validation errors in json
        } else {
            try {
                $department = new Department();
                $department->department_name = $request->department_name;
                $department->save();
                return response()->json($department, 200);
            } catch (\Throwable $th) {
                return response()->json([
                    "Error:500" => "Save Unsuccessful!"
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @author HZ
     * @return Specific Department Data
     * @create date 29/08/2020
     */
    public function show($id)
    {
        $department = Department::whereId($id)->first();
        if ($department) {
            return response()->json($department, 200);
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
     * 
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int  $id
     * @author HZ
     * @return department json data
     * @create date 29/08/2020
     */
    public function update(Request $request, $id)
    {

        try {
            $department = Department::find($id);
            $department->department_name = $request->department_name;
            $department->update();
            return response()->json($department, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "Errror:500" => "Internal Server Error"
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @author HZ
     * @return Json Message
     * @create date 29/08/2020
     */
    public function destroy($id)
    {

        $department = Department::whereId($id)->first();

        if ($department) { //if search Id has in departments table is true?
            $department->delete(); //update the deleted_at time
            return response()->json([
                "Message" => "Delete Successfully"
            ], 200);
        } else {
            return response()->json([
                "Error: 400" => "Bad Input Request"
            ], 400);
        }
    }
}
