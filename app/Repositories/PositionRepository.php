<?php

namespace App\Repositories;

use App\Position;
use App\Repositories\Interfaces\PositionRepositoryInterface;
use Exception;

/**
 * Class PositionRepository.
 */
class PositionRepository implements PositionRepositoryInterface
{
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
}
