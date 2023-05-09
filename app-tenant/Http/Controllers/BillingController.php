<?php

namespace AppTenant\Http\Controllers;

use App\Models\Statical\Constant;
use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Profile;
use AppTenant\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Spark\Countries;
use Spark\Events\SubscriptionCreated;
use Spark\Features;
use Spark\Spark;
use Stripe\StripeClient;

class BillingController extends BaseController
{
    // public function index(Plan $pl)
    public function index()
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $prices = collect(
            $stripe->prices->all(['limit' => 100])->data
        );
        $plans = Spark::plans('user')->map(function ($plan) use ($prices) {
            if ($plan->trialDays === 99999) {
                $plan->price = '£0';
                $plan->rawPrice = 0;
                $plan->currency = 'Gbp';

            } else {
                if (! $stripePrice = $prices->firstWhere('id', $plan->id)) {
                    throw new \RuntimeException('Price ['.$plan->id.'] does not exist in your Stripe account.');
                }
    
                $plan->rawPrice = $stripePrice->unit_amount;
                $plan->price = Cashier::formatAmount($stripePrice->unit_amount, $stripePrice->currency);
                $plan->currency = $stripePrice->currency;
            }

            return $plan;
        });
        // for tests
        // $plans = Spark::plans('user')->map(function ($plan) {
        //     $plan->rawPrice = 1900;
        //     $plan->price = '$19';
        //     $plan->currency = 'Gbp';

        //     return $plan;
        // });

        $user_profile = t_profile();
        $subscription = $user_profile->subscription('default');
        $stripe_subscription = $subscription;

        return t_view('billing.index', [
            'countries'             => Countries::all(),
            'home_country'          => Features::option('eu-vat-collection', 'home-country'),
            'plans'                 => $plans,
            'selected_plan'         => ($subscription && $subscription->active()
                                        ? $plans->firstWhere('id', $subscription->stripe_plan)
                                        : null),
            'stripe_subscription'   => $stripe_subscription,
            'state'                 => $this->state($user_profile, $subscription),
            'stripe_version'        => Cashier::STRIPE_VERSION,
            'user_name'             => t_profile()->name,
        ]);
    }

    /**
     * Subscribe user to Demo (Trial) subscription
     */
    public function subscribeDemo()
    {
        $user_profile = t_profile();
        $stripe_id = Constant::SUBSCRIPTION_DEMO;
        $subscription = $user_profile->subscriptions()->create([
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

        event(new SubscriptionCreated($user_profile, $subscription));
        $tenant = Tenant::where('data->admin_profile_id', $user_profile->id)->first();

        return $this->jsonSuccess('', [
            'redirect'  => $tenant->domains()->first()->domain
        ]);
    }

    /**
     * Get the current subscription state.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @param  \Laravel\Cashier\Subscription  $subscription
     * @return string
     */
    protected function state(Profile $billable, $subscription)
    {
        if ($subscription && $subscription->onGracePeriod()) {
            return 'onGracePeriod';
        }

        if ($subscription && $subscription->active()) {
            return 'active';
        }

        return 'none';
    }
}
