<?php

namespace App\Http\Controllers;

use App\Department;
use App\DepHasPosition;
use App\EmpDepPosition;
use App\Position;
use Exception;
use Illuminate\Http\Request;

class DepHasPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dep_has_positions = DepHasPosition::all();
        return $dep_has_positions;
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
        $dep_has_positions = new DepHasPosition();
        $dep_has_positions->department_id = $request->department_id;
        $dep_has_positions->position_id = $request->position_id;
        $dep_has_positions->save();
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dep_has_positions = DepHasPosition::whereId($id)->firstOrFail();

        return $dep_has_positions;
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
        $dep_has_positions = DepHasPosition::whereId($id)->firstOrFail();
        $dep_has_positions->department_id = $request->department_id;
        $dep_has_positions->position_id = $request->position_id;
        $dep_has_positions->update();
        return $dep_has_positions;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dep_has_positions = DepHasPosition::whereId($id)->firstOrFail();
        $dep_has_positions->delete();
        return $dep_has_positions;
    }
    public function fdelete($id)
    {

        try {
            $emp_dep_pos = EmpDepPosition::where('department_id', $id)->firstOrFail();
            if ($emp_dep_pos) {
                EmpDepPosition::where('department_id', $id)->forcedelete(); //or
                //$emp_dep_pos->forcedelete();

            }

            $emp_has_pos = DepHasPosition::where('department_id', $id)->firstOrFail();
            if ($emp_has_pos) {
                $emp_has_pos->forcedelete();
            }
            $dep = Department::whereId($id)->firstOrFail();
            if ($dep) {
                $dep->forcedelete();
            }
            return response()->json([
                "message" => "Deleted"
            ]);
        } catch (Exception $e) {
            return response($e->getMessage());
        }
    }
}
