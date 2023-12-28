<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;

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
