<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/userLogin', [ApiController::class, 'userLogin']);

Route::post('/sendOtp', [ApiController::class, 'sendOtp']);
Route::post('/verifyOtp', [ApiController::class, 'verifyOtp']);


## masters ##
//Route::post('/getMasters', [ApiController::class, 'getMasters']);
Route::post('/getMasters', [ApiController::class, 'getMasters']);
Route::post('/mastersActions', [ApiController::class, 'mastersActions']);
Route::post('/upSertMasters', [ApiController::class, 'upSertMasters']);

## assemblies ##
Route::post('/upsertAssemblies', [ApiController::class, 'upsertAssemblies']);
Route::post('/getAssemblyByState', [ApiController::class, 'getAssemblyByState']);
Route::post('/assemblyActions', [ApiController::class, 'assemblyActions']);

## employees ##
Route::post('/employeeActions', [ApiController::class, 'employeeActions']);
Route::post('/getEmployees', [ApiController::class, 'getEmployees']);
Route::post('/upSertEmployees', [ApiController::class, 'upSertEmployees']);

## mandals ##
Route::post('/upSertMandals', [ApiController::class, 'upSertMandals']);
Route::post('/getMandalsByAssemblyId', [ApiController::class, 'getMandalsByAssemblyId']);
Route::post('/mandalActions', [ApiController::class, 'mandalActions']);

## muncipalities ##
Route::post('/upSertMuncipalities', [ApiController::class, 'upSertMuncipalities']);
Route::post('/getMuncipalityByState', [ApiController::class, 'getMuncipalityByState']);
Route::post('/muncipalityActions', [ApiController::class, 'muncipalityActions']);

## wards ##
Route::post('/upSertWards', [ApiController::class, 'upSertWards']);
Route::post('/getWardsByMuncipality', [ApiController::class, 'getWardsByMuncipality']);
Route::post('/wardActions', [ApiController::class, 'wardActions']);

## mandal polling stations ##
Route::post('/getMandalPollingStations', [ApiController::class, 'getMandalPollingStations']);
Route::post('/upSertMandalPollingStations', [ApiController::class, 'upSertMandalPollingStations']);
Route::post('/mandalPollingStationsActions', [ApiController::class, 'mandalPollingStationsActions']);

## ward polling stations ##
Route::post('/getWardPollingStations', [ApiController::class, 'getWardPollingStations']);
Route::post('/upSertWardPollingStations', [ApiController::class, 'upSertWardPollingStations']);
Route::post('/wardPollingStationsActions', [ApiController::class, 'wardPollingStationsActions']);

## party symbols ##
Route::get('/getPartySymbols', [ApiController::class, 'getPartySymbols']);
Route::get('/getStates', [ApiController::class, 'getStates']);

## questions and options masters ##
Route::post('/upSertQuesOptionsMasters', [ApiController::class, 'upSertQuesOptionsMasters']);
Route::post('/getQuesOptionsMasters', [ApiController::class, 'getQuesOptionsMasters']);

## surveys ##
Route::post('/upSertSurvey', [ApiController::class, 'upSertSurvey']);
Route::post('/getSurvey', [ApiController::class, 'getSurvey']);
Route::post('/getSurveyDetails', [ApiController::class, 'getSurveyDetails']);

## servey records ##
Route::post('/insertSurveyRecords', [ApiController::class, 'insertSurveyRecords']);
Route::post('/uploadLocUrl', [ApiController::class, 'uploadLocUrl']);


