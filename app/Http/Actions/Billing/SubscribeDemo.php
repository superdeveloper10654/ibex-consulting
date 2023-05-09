<?php

namespace App\Http\Actions\Billing;

use App\Http\Actions\BaseAction;
use App\Models\Profile;
use App\Models\Statical\Constant;
use App\Models\Tenant;
use Spark\Events\SubscriptionCreated;

/**
 * Subscribe user profile for Demo subscription and generate tenant environment
 */
class SubscribeDemo extends BaseAction
{
    /** @var Profile */
    protected $user_profile;

    public function __construct(Profile $user_profile)
    {
        $this->user_profile = $user_profile;
    }
    
    public function handle()
    {
        $stripe_id = Constant::SUBSCRIPTION_DEMO;
        $subscription = $this->user_profile->subscriptions()->create([
            'name'          => 'default',
            'stripe_id'     => $stripe_id,
            'stripe_status' => 'active',
            'stripe_plan'   => $stripe_id,
            'quantity'      => 1,
            'trial_ends_at' => null,
            'ends_at'       => null,
        ]);

        $subscription->items()->create([
            'subscription_id'   => $subscription->id,
            'stripe_id'         => $stripe_id,
            'stripe_plan'       => $stripe_id,
            'quantity'          => env('TEAM_USERS_COUNT_DEMO'),
        ]);

        event(new SubscriptionCreated($this->user_profile, $subscription));
        $tenant = Tenant::where('data->admin_profile_id', $this->user_profile->id)->first();

        return $this->success([
            'tenant'  => $tenant,
        ]);
    }
}