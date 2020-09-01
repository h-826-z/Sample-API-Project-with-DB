<?php

namespace App\Http\Controllers;

use App\Department;
use App\DepHasPosition;
use App\EmpDepPosition;
use App\Position;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/** *Here is DepHasPositionController to show,store,insert,update,delete,search data
 * * @author HZ
 * @create date 28/08/2020 * */
class DepHasPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *@author HZ
     * @return DepHasPosition table  data
     * @create date 29/08/2020
     */
    public function index()
    {
        $dep_has_positions = DepHasPosition::all();
        if ($dep_has_positions) {
            return response()->json($dep_has_positions, 200);
        } else {
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @author HZ
     * @return DepHasPositions Model
     * @create date 29/08/2020
     */
    public function store(Request $request)
    {
        //validation check
        $validator = Validator::make(
            $request->all(),
            [
                'department_id' => 'required',
                'position_id' => 'required'
            ]
        );
        if ($validator->fails()) { //if validation =false
            return response()->json($validator->errors(), 422);
        } else {
            try {
                $dep_has_positions = new DepHasPosition();
                $dep_has_positions->department_id = $request->department_id;
                $dep_has_positions->position_id = $request->position_id;
                $dep_has_positions->save();
                return response()->json($dep_has_positions, 200);
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dep_has_positions = DepHasPosition::whereId($id)->first();

        if ($dep_has_positions) {
            return response()->json($dep_has_positions, 200);
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
        try {
            $dep_has_positions = DepHasPosition::whereId($id)->firstOrFail();
            $dep_has_positions->department_id = $request->department_id;
            $dep_has_positions->position_id = $request->position_id;
            $dep_has_positions->update();
            return response()->json($dep_has_positions, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "Error:500" => "Internal Server Error"
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dep_has_positions = DepHasPosition::whereId($id)->first();

        if ($dep_has_positions) {
            $dep_has_positions->delete();
            return response()->json([
                "message" => "Deleted"
            ], 200);
        } else {
            return response()->json([
                "Error" => "Id not found"
            ], 400);
        }
    }

    /** *Here is Force Delete  
     * * @author HZ
     * @create date 31/08/2020
     * @param id @return Deleted Message * */
    /*public function fdelete($id)
    {

        try {
            $emp_dep_pos = EmpDepPosition::where('department_id', $id)->firstOrFail();
            return response()->json([
                "message" => "Deleted"
            ]);
        } catch (Exception $e) {
            return response($e->getMessage());
        }
    }*/
}
