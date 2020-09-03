<?php

namespace App\Repositories;

use App\Position;
use App\Repositories\Interfaces\PositionRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class PositionRepository to save,check,update the request data to position table
 * @author HZ
 * @create date 02/09/2020
 */
class PositionRepository implements PositionRepositoryInterface
{
    /**
     * Save request data to position table
     * @author HZ
     * @param $request
     * @return 1 or 0
     * @create date 02/09/2020
     */
    public function savePosition($request)
    {
        $positions=new Position();
        $positions->position_id=$request->position_id;
        $positions->position_rank=$request->position_rank;
        try {
            $positions->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
        
    }
    /**
     * check request data that it has in position table
     * @author HZ
     * @param $request
     * @return specific position 
     * @create date 03/09/2020
     */
    public function checkPosition($request)
    {
        $posId=$request->id;
        $position= DB::table('positions')
                        ->where('id',$posId)
                        ->get();
        return $position;

    }
    /**
     * update request data in position table
     * @author HZ
     * @param $request
     * @return 1 or 0
     * @create date 03/09/2020
     */
    public function updatePosition($request)
    {
        try {
            DB::table('positions')
            ->where('id',$request->id)
            ->update([
                'position_name' => $request->position_name, 
                'position_rank' => $request->position_rank
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
