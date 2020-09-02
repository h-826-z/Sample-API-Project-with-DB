<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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

Route::apiResource('/employees', 'EmployeeController');
Route::apiResource('/departments', 'DepartmentController');
Route::apiResource('/positions', 'PositionController');
Route::apiResource('/department-positions', 'DepHasPositionController');


//custom routes
Route::delete('/deparment-positions/{id}/force-delete', 'DepHasPositionController@fdelete');
Route::delete('/employees/{id}/force-delete', 'EmployeeController@fdelete');

Route::get('/employee-export','EmployeeController@export');
Route::post('/employees/search','EmployeeController@search');
//validation with Repository
Route::get('/saveEmp','EmployeeRegistrationController@save');
Route::put('/updateEmp','EmployeeRegistrationController@update');
Route::get('/savePos','PositionRegistrationController@save');
