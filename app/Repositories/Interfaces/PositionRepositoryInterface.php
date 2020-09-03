<?php

namespace App\Repositories\Interfaces;

interface PositionRepositoryInterface 
{
    
    public function savePosition($request);
    public function checkPosition($request);
    public function updatePosition($request);
}