<?php

namespace App\Http\Controllers;

use Locale;

use App\Position;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $position = Position::withTrashed()->get();
        return $position;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $position = new Position();
        $position->position_name = $request->position_name;
        $position->position_rank = $request->position_rank;
        $position->save();
        return $position;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position=Position::whereId($id)->withTrashed()->get();
        return $position;
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
        try{
            //$position=Position::find($id);
            $position =Position::find($id);
            $position->position_name = $request->position_name;
            $position->position_rank = $request->position_rank;
            $position->update();
            return response($position);
        }catch(Exception $e){
            return response($e->getMessage());
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
        //$position=Position::find($id);
        $position = Position::whereId($id)->firstOrFail();

        
        $position->delete();
        return  $position;
    }
}
