<?php

namespace App\Http\Controllers;

use Locale;

use App\Position;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** *Here is Position Controller to show,store,insert,update,delete,search data
 * * @author HZ
 * @create date 28/08/2020 * */
class PositionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //need to be able to get the trashed positions too, but only for this instance and in this function
        try {
            $position = Position::all();
            return response($position, 200);
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
        $validator = Validator::make(
            $request->all(),
            [
                'position_name' => 'required|min:5|max:20',
                'position_rank' => 'required',
            ]
        );
        if ($validator->fails()) { //if validation is false
            return response()->json($validator->errors(), 422); //422 is Unprocessable Entity  error code
        } else {
            try {
                $position = new Position();
                $position->position_name = $request->position_name;
                $position->position_rank = $request->position_rank;
                $position->save();
                return response()->json($position, 200);
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
        $position = Position::whereId($id)->first();
        if ($position) {
            return response()->json($position, 200);
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
     * @return Position object
     */
    public function update(Request $request, $id)
    {
        try {
            //$position=Position::find($id);
            $position = Position::find($id);
            $position->position_name = $request->position_name;
            $position->position_rank = $request->position_rank;
            $position->update();
            return response()->json($position, 200);
        } catch (Exception $e) {
            return response()->json([
                "Errror:500" => "Internal Server Error"
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
        //$position=Position::find($id);
        $position = Position::whereId($id)->first();

        if ($position) {
            $position->delete();
            return response()->json([
                "message" => "Deleted"
            ], 200);
        } else {
            return response()->json([
                "Error" => "Id not found"
            ], 400);
        }
    }
}
