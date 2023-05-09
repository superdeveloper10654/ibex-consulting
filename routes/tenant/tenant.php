<?php

declare(strict_types=1);

use AppTenant\Http\Controllers\AuthController;
use AppTenant\Http\Controllers\BillingController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Features\UserImpersonation;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/


Route::middleware(['tenant.auth'])->group(function () {
    Route::get('/billing', [BillingController::class, 'index'])->name('billing')->middleware('tenant.can:manage-billing');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::middleware(['tenant.subscription.demo-or-paid'])
        ->group(base_path('routes/tenant/subscription-demo.php'));
    Route::middleware(['tenant.subscription.paid'])
        ->group(base_path('routes/tenant/subscription-paid.php'));
});

Route::middleware(['tenant.guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'loginSetup'])->name('auth.login-setup');
});

Route::get('/impersonate-custom-name125/{token}', function ($token) {
    return UserImpersonation::makeResponse($token);
})->name('impersonate');
