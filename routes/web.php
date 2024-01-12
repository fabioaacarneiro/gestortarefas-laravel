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
    // login routes
    Route::get('/login', [Login::class, 'login'])->name('login');
    Route::post('/login_submit', [Login::class, 'loginSubmit'])->name('login.submit');
});

// in app
Route::middleware('CheckLogin')->group(function () {
    // login routes
    Route::get('/', [Login::class, 'index'])->name('main.index');
    Route::get('/logout', [Login::class, 'logout'])->name('main.logout');

    // tasks
    Route::get('/', [Task::class, 'index'])->name('task.index');
    Route::get('/newTask', [Task::class, 'newTask'])->name('task.new');
    Route::post('/newTask', [Task::class, 'newTaskSubmit'])->name('task.new.submit');

    // task - edit
    Route::get('/editTask/{id}', [Task::class, 'editTask'])->name('task.edit');
    Route::post('/editTaskSubmit', [Task::class, 'editTaskSubmit'])->name('task.edit.submit');

    // task - delete
    Route::get('/deleteTask/{id}', [Task::class, 'deleteTask'])->name('task.delete');
    Route::get('/deleteTask/{id}', [Task::class, 'deleteTaskConfirm'])->name('task.delete.submit');

    // search
    Route::post('/searchSubmit', [Task::class, 'searchSubmit'])->name('task.search');

    // filter
    Route::get('/filter', [Task::class, 'filter'])->name('task.filter');

});
