<?php

use App\Http\Controllers\Billing\BillingController;
use App\Models\Statical\Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| This file describes routes for root application (non-tenant).
| Later all the super-admin routes will be moved here to manage across all the tenants
*/

Route::middleware(['auth'])->group(function() {
    Route::get('/billing', [BillingController::class, 'index'])->name('billing')->middleware('can:manage-billing');
    Route::post('/billing/subscribe-demo', [BillingController::class, 'subscribeDemo'])->name('billing.subscribe-demo')->middleware('can:manage-billing');
    Route::get('/dashboard', function() {
        return redirect(route('billing'));
    })->name('dashboard');

    Route::get('/profiles/' . Constant::ME . '/edit', function () {
        return App::call('App\Http\Controllers\ProfilesController@edit', ['id' => Constant::ME]);
    })->name('profiles.edit.me');
    Route::put('/profiles/' . Constant::ME . '/update', function () {
        return App::call('App\Http\Controllers\ProfilesController@update', ['id' => Constant::ME]);
    })->name('profiles.update.me');  
});


// login routes for rest users
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Language Translation
// Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);