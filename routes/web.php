<?php

use App\Http\Controllers\Main;
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
    Route::get('/login', [Main::class, 'login'])->name('login');
    Route::post('/login_submit', [Main::class, 'login_submit'])->name('login_submit');
});

// in app
Route::middleware('CheckLogin')->group(function () {
    // main routes
    Route::get('/', [Main::class, 'index'])->name('index');
    Route::get('/logout', [Main::class, 'logout'])->name('logout');

    // tasks
    Route::get('/new_task', [Main::class, 'new_task'])->name('new_task');
    Route::post('/new_task_submit', [Main::class, 'new_task_submit'])->name('new_task_submit');

    // task - edit
    Route::get('/edit_task/{id}', [Main::class, 'edit_task'])->name('edit_task');
    Route::post('/edit_task_submit/', [Main::class, 'edit_task_submit'])->name('edit_task_submit');

    // task - delete
    Route::get('/delete_task/{id}', [Main::class, 'delete_task'])->name('delete_task');
    Route::get('/delete_task_confirm/{id}', [Main::class, 'delete_task_confirm'])->name('delete_task_confirm');

    // search
    Route::post('/search_submit', [Main::class, 'search_submit'])->name('search_submit');

    // filter
    Route::get('/filter/{filter}', [Main::class, 'filter'])->name('filter');

});
