<?php

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
});

// Auth::routes();

Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Registration Routes...
Route::get('users', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('users', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get('transactions', [App\Http\Controllers\TransactionController::class, 'showTransaction'])->name('transactions');
Route::get('getTransactionList', [App\Http\Controllers\TransactionController::class, 'getTransactionList'])->name('getTransactionList');

Route::get('deposit', [App\Http\Controllers\TransactionController::class, 'depositIndex'])->name('deposit');
Route::post('deposit', [App\Http\Controllers\TransactionController::class, 'deposit'])->name('deposit');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');