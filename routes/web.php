<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\SignUp;
use App\Http\Controllers\Task;
use App\Http\Controllers\Tasklist;
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
    Route::post('/login', 'loginSubmit')->name('login.submit');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/logout', 'logoutSubmit')->name('logout.submit');
});

Route::controller(Tasklist::class)->group(function () {
    Route::get('/tasklist', 'lists')->name('tasklist');
    Route::post('/tasklist/new-list', 'storeTasklist')->name('tasklist.new');
    Route::post('/tasklist/edit-list', 'editTasklist')->name('tasklist.edit');
    Route::get('/tasklist/delete-list/{id}', 'deleteTasklist')->name('tasklist.delete');
    Route::get('/', 'index')->name('tasklist.index');
    Route::get('/tasklist/search/{search?}', 'searchTasklist')->name('tasklist.search');
})->middleware('auth');

Route::controller(Task::class)->group(function () {
    Route::post('/tasklist/{tasklist_id}/new-task', 'newTask')->name('task.new');
    Route::post('/tasklist/{tasklist_id}/set-commentary', 'setCommentary')->name('task.setcommentary');
    Route::post('/tasklist/{tasklist_id}/edit-task', 'editTask')->name('task.edit');
    Route::get('/tasklist/{tasklist_id}/delete-task/{id}', 'deleteTask')->name('task.delete');
    Route::get('/tasklist/{tasklist_id}/search/{search?}', 'searchTask')->name('task.search');
    Route::get('/tasklist/{tasklist_id}/tasks/{filter?}', 'index')->name('task.index');
})->middleware('auth');
