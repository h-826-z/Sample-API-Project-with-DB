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
        $department = Department::all();
        return $department;
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
                'department_name' => 'required|alpha|min:5|max:20',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $department = new Department();
            $department->department_name = $request->department_name;
            $department->save();
            return $department;
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
        return Department::find($id);
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
        $department = Department::find($id);
        $department->department_name = $request->department_name;
        $department->update();
        return  $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $department = Department::whereId($id)->firstOrFail();
        $department->delete();
        return  $department;
    }

    /** *Here is force delete the department 
     * * @author HZ
     * @create date 31/08/2020
     * @param id @return Message * */
    /*public function fdelete($id)
    {
        try {
            $emp_dep_pos = EmpDepPosition::where('department_id', $id)->firstOrFail();
            if ($emp_dep_pos) {
                EmpDepPosition::where('department_id',$id)->forcedelete();//or
                //$emp_dep_pos->forcedelete();

            }
            $dep_pos=DepHasPosition::where('department_id',$id)->firstOrFail();
            if($dep_pos){
                DepHasPosition::where('department_id',$id)->forcedelete();
            }
            $dep=Department::where($id)->firstOrFail();
            if($dep){
                Department::where($id)->forcedelete();
            }
            return response()->json([
                "message" => "Deleted"
            ]);

        } catch (Exception $e) {
            return response($e->getMessage());
        }


    }*/
}
