<?php

use AppCentralAdmin\Http\Controllers\AuthController;
use AppCentralAdmin\Http\Controllers\TenantsController;
use AppCentralAdmin\Services\CA;
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

Route::prefix('admin')
    ->name('central.admin.')
    ->group(function() {
        Route::middleware('central.admin.guest')->group(function() {
            Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
            Route::post('/login', [AuthController::class, 'loginSetup'])->name('auth.login-setup');
        });

        Route::middleware('central.admin.auth')->group(function() {
            Route::get('/', function() {
                return redirect(CA::route('tenants'));
            })->name('home');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/tenants', [TenantsController::class, 'index'])->name('tenants');
            Route::get('/tenants/create', [TenantsController::class, 'create'])->name('tenants.create');
            Route::post('/tenants/store', [TenantsController::class, 'store'])->name('tenants.store');
            Route::any('/tenants/delete/{id}', [TenantsController::class, 'delete'])->name('tenants.delete');
            Route::any('/tenants/login-as-admin/{id}', [TenantsController::class, 'loginAsAdmin'])->name('tenants.login-as-admin');
        });
    });