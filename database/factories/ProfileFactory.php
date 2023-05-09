<?php

namespace Database\Factories;

use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\Role;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spark\Events\SubscriptionCreated;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = FakerFactory::create();
        return [
            'first_name'    => $faker->firstName(),
            'last_name'     => $faker->lastName(),
            'email'         => $faker->email(),
            'organisation'  => $faker->company(),
            'department'    => Department::COMMERCIAL_ID,
            'role'          => Role::ADMIN_ID,
            'password'      => Hash::make('das4jvDas_8va3jVhd'),
            'avatar'        => '/assets/images/svg/help-support.svg',
            'created_at'    => Date::now(),
            'updated_at'    => Date::now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the model's role should be admin
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => Role::ADMIN_ID,
            ];
        });
    }

    /**
     * Indicate that the model's role should be contractor
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function contractor()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => Role::CONTRACTOR_ID,
            ];
        });
    }

    /**
     * Indicate that the model's department should be commercial
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function commercial()
    {
        return $this->state(function (array $attributes) {
            return [
                'department' => Department::COMMERCIAL_ID,
            ];
        });
    }

    /**
     * Indicate that the model's department should be operational
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function operational()
    {
        return $this->state(function (array $attributes) {
            return [
                'department' => Department::OPERATIONAL_ID,
            ];
        });
    }

    /**
     * Indicate that the model should have a subscription plan.
     *
     * @param  int  $plan_id
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withSubscription($plan_id = null, $event_trigger = false)
    {
        return $this->afterCreating(function ($user_profile) use ($plan_id, $event_trigger) {
            $stripe_id = Str::random(10);
            $subscription = $user_profile->subscriptions()->create([
                'name'          => 'default',
                'stripe_id'     => $stripe_id,
                'stripe_status' => 'active',
                'stripe_plan'   => $plan_id,
                'quantity'      => 1,
                'trial_ends_at' => null,
                'ends_at'       => null,
            ]);

            $subscription->items()->create([
                'subscription_id'   => $subscription->id,
                'stripe_id'         => $stripe_id,
                'stripe_plan'       => $plan_id,
                'quantity'          => 5,
            ]);

            if ($event_trigger) {
                event(new SubscriptionCreated($user_profile, $subscription));
            }
        });
    }
}
