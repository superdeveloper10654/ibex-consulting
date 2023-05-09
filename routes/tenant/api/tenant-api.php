<?php

declare(strict_types=1);

use AppTenant\Http\Controllers\GanttController;
use AppTenant\Http\Controllers\TaskController;
use AppTenant\Http\Controllers\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant API routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/')->name('root');

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('tenant.subscription.demo-or-paid')->group(function() {
        // Route::middleware('tenant.can:programmes.update')->group(function() { // for some reason it doesn't work
            Route::get('/data/{id}', [GanttController::class, 'get'])->name('data');
            Route::resource('/task', TaskController::class);
            Route::resource('/link', LinkController::class);
            Route::post('/link', [LinkController::class, 'store'])->name('link');
        // });
    });
});
