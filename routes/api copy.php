<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Administration;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\CheckupsController;
use App\Http\Controllers\OwnersController;

use Morilog\Jalali\Jalalian;

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

//protected routes

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/user/logout', [Administration::class, 'logout']);
    Route::put('/user/edit', [Administration::class, 'updateUserInfo']);
    Route::post('/user/data', [Administration::class, 'getUserData']);
    Route::post('/user/delete', [Administration::class, 'deleteUser']);
    Route::post('/user/get-all', [Administration::class, 'getAllUsers']);

    Route::post('/owner/create', [OwnersController::class, 'CreateOwner']);
    Route::get('/owner/search', [OwnersController::class, 'FindOwner']);

    Route::post('/patients/add', [PatientsController::class, 'CreatePatient']);
    Route::get('/patients/search', [PatientsController::class, 'FindPatient']);
    Route::get('/patients/all', [PatientsController::class, 'GetAllPatients']);

    Route::post('/checkups/add', [CheckupsController::class, 'CreateCheckUp']);
});

//public routes

Route::post('/user/register', [Administration::class, 'register']);
Route::post('/user/login', [Administration::class, 'login']);

Route::get('cdate', function(){
    $date = jDate();
    // $date = Jalalian::now();
    // $date = date('Y-m-d H:i:s');
    return $date;
});