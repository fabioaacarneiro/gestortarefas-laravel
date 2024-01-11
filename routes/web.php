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
    Route::get('/new_task', [Task::class, 'new_task'])->name('task.new_task');
    Route::post('/new_task', [Task::class, 'new_task_submit'])->name('task.new_task_submit');

    // task - edit
    Route::get('/edit_task/{id}', [Task::class, 'edit_task'])->name('task.edit_task');
    Route::post('/edit_task', [Task::class, 'edit_task_submit'])->name('task.edit_task_submit');

    // task - delete
    Route::get('/delete_task/{id}', [Task::class, 'delete_task'])->name('task.delete_task');
    Route::get('/delete_task_confirm/{id}', [Task::class, 'delete_task_confirm'])->name('task.delete_task_confirm');

    // search
    Route::post('/search_submit', [Task::class, 'search_submit'])->name('task.search_submit');

    // filter
    Route::get('/filter/{filter}', [Task::class, 'filter'])->name('task.filter');

});
