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
}
