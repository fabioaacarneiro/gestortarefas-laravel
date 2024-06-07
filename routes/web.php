<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\Main;
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
    Route::get('/googleLogin', 'googleLogin')->name('login.google');
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginSubmit')->name('login.submit');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/logout', 'logoutSubmit')->name('logout.submit');
});

Route::controller(Tasklist::class)->group(function () {
    // get task lists to populate select on edit modal
    Route::get('/tasklist/get/{task_id?}', 'getTasklists')->name('tasklist.get');

    Route::get('/tasklist', 'showTasklist')->name('tasklist.show'); // listas de tarefas
    Route::post('/tasklist/new', 'storeTasklist')->name('tasklist.new');
    Route::post('/tasklist/edit', 'editTasklist')->name('tasklist.edit');
    Route::get('/tasklist/{list_id}/delete', 'deleteTasklist')->name('tasklist.delete');
    Route::get('/tasklist/home', 'index')->name('tasklist.index');
    Route::get('/tasklist/search/{search?}', 'searchTasklist')->name('tasklist.search');
})->middleware('auth');

Route::controller(Task::class)->group(function () {
    // homepage of user logged in
    Route::get('/', 'index')->name('index');
    Route::get('/userhome', 'userhome')->name('task.userhome');

    // routes of tasks without list
    Route::get('/task', 'tasks')->name('task.show');
    Route::post('/task/new', 'newTask')->name('task.new'); // check
    Route::post('/task/{task_id}/commentary', 'setCommentaryTask')->name('task.setCommentary'); // check
    Route::post('/task/{task_id}/edit', 'editTask')->name('task.edit');
    Route::get('/task/{task_id}/delete', 'deleteTask')->name('task.delete');
    Route::get('/task/{search?}/search', 'searchTask')->name('task.search');
    Route::get('/task/{filter?}/filter', 'filterTask')->name('task.filter');

    // routes of tasks with list
    Route::post('/tasklist/{list_id}/task/new', 'newTaskWithList')->name('taskWithList.new'); // check
    Route::post('/tasklist/{list_id}/task/edit', 'editTaskWithList')->name('taskWithList.edit');
    Route::get('/tasklist/{list_id}/task/{task_id}/delete', 'deleteTaskWithList')->name('taskWithList.delete');
    Route::get('/tasklist/{list_id}/search/{search?}', 'searchTaskWithList')->name('taskWithList.search');
    Route::get('/tasklist/{list_id}/filter/{filter?}', 'filterTaskWithList')->name('taskWithList.show');
})->middleware('auth');

Route::controller(Main::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/resources', 'resources')->name('resources');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/about_developer', 'developer')->name('developer');
});
