<?php

use App\Http\Controllers\Login;
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

// out app
Route::middleware('CheckLogout')->group(function () {

    // login index
    Route::get('/login', [Login::class, 'login'])->name('login');

    // login submit
    Route::post('/login_submit', [Login::class, 'loginSubmit'])->name('login.submit');
});

// in app
Route::middleware('CheckLogin')->group(function () {

    // logout user (this route needs to be the first route declaration)
    Route::get('/logout', [Login::class, 'logout'])->name('logout.submit');

    // task - new
    Route::post('/newTask', [Task::class, 'newTask'])->name('task.new');

    // task - edit
    Route::post('/editTask', [Task::class, 'editTask'])->name('task.edit');

    // task - delete
    Route::get('/deleteTask/{id}', [Task::class, 'deleteTask'])->name('task.delete');

    // task - search
    Route::get('/search/{serach?}', [Task::class, 'searchTask'])->name('task.search');

    // task - index
    Route::get('/{filter?}', [Task::class, 'index'])->name('task.index');

});
