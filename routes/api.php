<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Administration;
use App\Http\Controllers\AnimalsController;
use App\Http\Controllers\RacesController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\CheckupsController;
use App\Http\Controllers\OwnersController;
use App\Http\Controllers\SettingsController;

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

Route::middleware(['auth:sanctum'])->group(function(){

    Route::controller(Administration::class)->group(function(){
        
        Route::post('/user/logout', 'logout');
        Route::put('/user/edit', 'updateUserInfo');
        Route::post('/user/data', 'getUserData');
        Route::post('/user/delete', 'deleteUser');
        Route::post('/user/get-all', 'getAllUsers');
    });

    Route::controller(PatientsController::class)->group(function(){

        Route::post('/patients/add', 'CreatePatient');
        Route::get('/patients/search', 'FindPatient');
        Route::get('/patients/all', 'GetAllPatients');
        Route::get('/patients/find', 'FindPatientById');
    });
    
    Route::controller(CheckupsController::class)->group(function(){

        Route::post('/checkups/add', 'CreateCheckUp');
        Route::get('/checkups/all', 'GetAllCheckups');
        Route::get('/checkups/find/patient', 'FindCheckupsByPatientName');
        Route::get('/checkups/find/owner', 'FindCheckupsByOwnerName');
        Route::get('/checkups/find/date', 'FindCheckupsByDate');
        
    });
    
    Route::controller(OwnersController::class)->group(function(){

        Route::post('/owner/create', 'CreateOwner');
        Route::get('/owner/search', 'FindOwner');
    });

    Route::controller(SettingsController::class)->group(function(){
        
        Route::post('settings/set', 'SetSettings');
        Route::get('settings/get', 'GetSettings');
    });

    Route::controller(AnimalsController::class)->group(function(){

        Route::post('animals/add', 'Add');
        Route::get('animals/get', 'Get');
        Route::get('animals/all', 'All');
        Route::delete('animals/delete', 'Remove');
        Route::get('animals/races', 'GetAnimalRaces');
    });

    Route::controller(RacesController::class)->group(function(){

        Route::post('races/add', 'Add');
        Route::get('races/get', 'Get');
        Route::delete('races/delete', 'Remove');
    });
});

Route::post('/user/register', [Administration::class, 'register']);
Route::post('/user/login', [Administration::class, 'login']);