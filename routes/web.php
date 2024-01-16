<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\SignUp;
use App\Http\Controllers\Task;
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

Route::controller(SignUp::class)->group(function () {
    Route::get('/signup', 'signUp')->name('signup');
    Route::post('/signup', 'signUpSubmit')->name('signup.submit');
});

Route::controller(Login::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login_submit', 'loginSubmit')->name('login.submit');
    Route::get('/logout', 'logout')->name('logout.submit');
})->middleware('auth');

Route::controller(Task::class)->group(function () {
    Route::post('/newTask', 'newTask')->name('task.new');
    Route::post('/editTask', 'editTask')->name('task.edit');
    Route::get('/deleteTask/{id}', 'deleteTask')->name('task.delete');
    Route::get('/search/{serach?}', 'searchTask')->name('task.search');
    Route::get('/{filter?}', 'index')->name('task.index');
})->middleware('auth');
