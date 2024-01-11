<?php

use App\Http\Controllers\Main;
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
    Route::get('/login', [Main::class, 'login'])->name('main.login');
    Route::post('/login_submit', [Main::class, 'login_submit'])->name('main.login_submit');
});

// in app
Route::middleware('CheckLogin')->group(function () {
    // main routes
    Route::get('/', [Main::class, 'index'])->name('main.index');
    Route::get('/logout', [Main::class, 'logout'])->name('main.logout');

    // tasks
    // Route::get('/', [Task::class, 'index'])->name('task.index');
    Route::get('/newTask', [Task::class, 'newTask'])->name('task.newTask');
    Route::post('/newTask', [Task::class, 'newTaskSubmit'])->name('task.newTaskSubmit');

    // task - edit
    Route::get('/editTask/{id}', [Task::class, 'editTask'])->name('task.editTask');
    Route::post('/editTask', [Task::class, 'editTaskSubmit'])->name('task.editTaskSubmit');

    // task - delete
    Route::get('/deleteTask/{id}', [Task::class, 'deleteTask'])->name('task.deleteTask');
    Route::post('/deleteTask/{id}', [Task::class, 'deleteTaskConfirm'])->name('task.deleteTaskConfirm');

    // search
    Route::post('/searchSubmit', [Task::class, 'searchSubmit'])->name('task.searchSubmit');

    // filter
    Route::get('/filter/{filter}', [Task::class, 'filter'])->name('task.filter');

});
