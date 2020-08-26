<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/employees','EmployeeController');
Route::apiResource('/departments','DepartmentController');
Route::apiResource('/positions','PositionController');
Route::apiResource('/department-positions','DepHasPositionController');
Route::apiResource('/department-positions/{id}/force-delete','DepHasPositionController@fdelete');
