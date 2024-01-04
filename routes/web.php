<?php

use App\Models\Employee;
use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SurveyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthManager::class, 'login'])->name('login')->middleware('alreadyLoggedIn');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
Route::get('/dashboard', [AuthManager::class, 'dashboard'])->name('dashboard')->middleware('isLoggedIn');
Route::get('/profile', [AuthManager::class, 'profile'])->name('profile')->middleware('isLoggedIn');
Route::get('/change-password', [AuthManager::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [AuthManager::class, 'changePasswordPost'])->name('change.password.post');
Route::get('/view-employees', [Employee::class, 'viewEmployees'])->name('view.employees');
Route::get('/view-surveys', [SurveyController::class, 'viewSurveys'])->name('view.surveys');
//Route::put('/update_status/{id}', 'SurveyController@updateStatus');
Route::post('/update_status', [SurveyController::class, 'updateStatus'])->name('update.survey');

Route::get('survey/{id}', [SurveyController::class, 'updateStatus']);
Route::get('survey-delete/{id}', [SurveyController::class, 'updateStatus2']);

Route::get('/survey-add', [SurveyController::class, 'surveyAdd'])->name('survey-add');
Route::get('/get-constituencies/{stateId}', [StateController::class, 'getConstituencies'])->name('get.constituencies');



