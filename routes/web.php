<?php

use App\Http\Controllers\Dashboard;
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

Route::controller(Dashboard::class)->group(function () {
    Route::get('/lists', 'index')->name('dashboard');
})->middleware('auth');

Route::controller(Login::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginSubmit')->name('login.submit');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/logout', 'logoutSubmit')->name('logout.submit');
});

Route::controller(Task::class)->group(function () {
    Route::post('/new-task', 'newTask')->name('task.new');
    Route::post('/edit-task', 'editTask')->name('task.edit');
    Route::get('/delete-task/{id}', 'deleteTask')->name('task.delete');
    Route::get('/search/{search?}', 'searchTask')->name('task.search');
    Route::get('/tasks/{filter?}', 'index')->name('task.index');
    // Route::get('/', 'index')->name('task.index');

})->middleware('auth');
