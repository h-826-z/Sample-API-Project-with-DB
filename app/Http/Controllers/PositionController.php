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
        $validator = Validator::make(
            $request->all(),
            [
                'position_name' => 'required|alpha|min:5|max:20',
                'position_rank' => 'required',
            ]
        );
        if ($validator->fails()) {//if validation is false
            return response()->json($validator->errors(), 422);//422 is Unprocessable Entity  error code
        } else {
            $position = new Position();
            $position->position_name = $request->position_name;
            $position->position_rank = $request->position_rank;
            $position->save();
            return $position;
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
        $position = Position::whereId($id)->withTrashed()->get();
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
            return response($position);
        } catch (Exception $e) {
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
