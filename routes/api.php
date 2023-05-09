<?php

use Illuminate\Support\Facades\Route;

use AppTenant\Http\Controllers\GanttController;
use AppTenant\Http\Controllers\TaskController;
use AppTenant\Http\Controllers\LinkController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/')->name('root');
Route::get('/data/{id}', [GanttController::class, 'get'])->name('data');
Route::resource('/task', TaskController::class);
Route::resource('/link', LinkController::class);
Route::post('/link', [LinkController::class,'store'])->name('link');
Route::post('/link/update', [LinkController::class,'update'])->name('link-update');


