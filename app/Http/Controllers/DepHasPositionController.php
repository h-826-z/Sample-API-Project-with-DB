<?php

namespace App\Http\Controllers;

use App\Department;
use App\DepHasPosition;
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
        $dep_has_positions=DepHasPosition::all();
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
        $dep_has_positions=new DepHasPosition();
        $dep_has_positions->department_id=$request->department_id;
        $dep_has_positions->position_id=$request->position_id;
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
        $dep_has_positions=DepHasPosition::whereId($id)->firstOrFail();
        
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
        $dep_has_positions=DepHasPosition::whereId($id)->firstOrFail();
        $dep_has_positions->department_id =$request->department_id;
        $dep_has_positions->position_id =$request->position_id;
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
        
    }
    public function fdelete($id)
    {
        $dep_has_positions=DepHasPosition::whereId($id)->firstOrFail();
        $dep_has_positions->delete();
        return true;
    }
}
