<?php

namespace App\Providers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Cashier\Cashier;
use Spark\Plan;
use Spark\Spark;

class SparkServiceProvider extends ServiceProvider
{
    public function register()
    {
        Spark::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cashier::useCustomerModel(Profile::class);
        Spark::billable(Profile::class)->resolve(function (Request $request) {
            return $request->user();
        });

        Spark::billable(Profile::class)->authorize(function (Profile $billable, Request $request) {
            return $request->user() &&
                   $request->user()->id == $billable->id;
        });

        Spark::billable(Profile::class)->chargePerSeat('per user', function (Profile $profile) {
            $is_demo = (bool) request()->post('is_demo', false);
            $users_count = (int) request()->post('users_count', $profile->team_users_count);

            if ($is_demo) {
                $users_count = env('TEAM_USERS_COUNT_DEMO');

            } else if ($users_count != $profile->team_users_count) {
                if ($users_count < env('TEAM_USERS_COUNT_MIN')) {
                    throw ValidationException::withMessages([
                        'plan' => (__('Minimum count of users:') . ' ' . config('TEAM_USERS_COUNT_MIN'))
                    ]);
                }

                $profile->team_users_count = $users_count;
                $profile->update();
            }

            return $users_count;
        });

        Spark::billable(Profile::class)->checkPlanEligibility(function (Profile $profile, Plan $plan) {
            // if ($profile->projects > 5 && $plan->name == 'Basic') {
            //     throw ValidationException::withMessages([
            //         'plan' => 'You have too many projects for the selected plan.'
            //     ]);
            // }
        });
    }
}
