<?php

use App\Models\Employee;
use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AssemblyController;
use App\Http\Controllers\ParliamentController;

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




// Route to display the list of states
Route::get('/states', [StateController::class, 'index'])->name('states.index');

// Route to display the form for creating a new state
Route::get('/states/create', [StateController::class, 'create'])->name('states.create');

// Route to store a new state
Route::post('/states', [StateController::class, 'store'])->name('states.store');

// Route to display the form for editing a state
Route::get('/states/{state}/edit', [StateController::class, 'edit'])->name('states.edit');

// Route to update a state
Route::put('/states/{state}', [StateController::class, 'update'])->name('states.update');

// Route to delete a state
Route::delete('/states/{state}', [StateController::class, 'destroy'])->name('states.destroy');


// Routes for assemblies
Route::get('/assemblies', [AssemblyController::class, 'index'])->name('assemblies.index');
Route::get('/assemblies/create', [AssemblyController::class, 'create'])->name('assemblies.create');
Route::post('/assemblies', [AssemblyController::class, 'store'])->name('assemblies.store');
Route::get('/assemblies/{assembly}/edit', [AssemblyController::class, 'edit'])->name('assemblies.edit');
Route::put('/assemblies/{assembly}', [AssemblyController::class, 'update'])->name('assemblies.update');
Route::delete('/assemblies/{assembly}', [AssemblyController::class, 'destroy'])->name('assemblies.destroy');

// Routes for parliaments
Route::get('/parliaments', [ParliamentController::class, 'index'])->name('parliaments.index');
Route::get('/parliaments/create', [ParliamentController::class, 'create'])->name('parliaments.create');
Route::post('/parliaments', [ParliamentController::class, 'store'])->name('parliaments.store');
Route::get('/parliaments/{parliament}/edit', [ParliamentController::class, 'edit'])->name('parliaments.edit');
Route::put('/parliaments/{parliament}', [ParliamentController::class, 'update'])->name('parliaments.update');
Route::delete('/parliaments/{parliament}', [ParliamentController::class, 'destroy'])->name('parliaments.destroy');

