<?php

use App\Http\Controllers\AuthController\ChangePasswordController;
use App\Http\Controllers\DashboardController\DashboardController;
use App\Http\Controllers\AuthController\LoginController;
use App\Http\Controllers\ProfileController\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('loginauth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/profiles', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change-password')->middleware('auth');
Route::post('/change-password', [ChangePasswordController::class, 'updatePassword'])->name('change-password')->middleware('auth');
Route::post('/change-profile', [ProfileController::class, 'changeProfile'])->name('change-profile')->middleware('auth');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/', function () {
    return redirect('/dashboard');
});
