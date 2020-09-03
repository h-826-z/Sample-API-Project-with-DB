<?php

namespace App\Http\Controllers;
use  App\Http\Requests\PositionRegistrationValidationRequest;
use App\Repositories\Interfaces\PositionRepositoryInterface;

class PositionRegistrationController extends Controller
{
    public function __construct(PositionRepositoryInterface $posRepo)
    {       
        $this->posRepo = $posRepo;

    }
    public function save(PositionRegistrationValidationRequest $request)
    {
        $this->posRepo->savePosition($request);
    }
    public function update(PositionRegistrationValidationRequest $request)
    {
        $position=$this->posRepo->checkPosition($request);
        if($position->isEmpty()){
            return response()->json([
                "Error" => "This position does not exit in Position List"
            ],400);
        }else{
            $this->posRepo->updatePosition($request);
        }
    }
}
