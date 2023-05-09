<?php

namespace App\Http\Controllers\Billing;

use App\Http\Actions\Billing\SubscribeDemo;
use App\Http\Controllers\Base\BaseController;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Spark\Countries;
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

        $user_profile = Auth::user();
        $subscription = $user_profile->subscription('default');
        $stripe_subscription = $subscription;

        return view('central.web.billing.index', [
            'countries'             => Countries::all(),
            'home_country'          => Features::option('eu-vat-collection', 'home-country'),
            'plans'                 => $plans,
            'selected_plan'         => ($subscription && $subscription->active()
                                        ? $plans->firstWhere('id', $subscription->stripe_plan)
                                        : null),
            'stripe_subscription'   => $stripe_subscription,
            'state'                 => $this->state($user_profile, $subscription),
            'stripe_version'        => Cashier::STRIPE_VERSION,
            'user_name'             => Auth::user()->name,
        ]);
    }

    /**
     * Subscribe user to Demo (Trial) subscription
     */
    public function subscribeDemo()
    {
        request()->validate([
            'subdomain'  => "required|max:63|regex:/^([a-zA-Z0-9][a-zA-Z0-9-_]*)/i"
        ]);

        $user_profile = Auth::user();
        $user_profile->preferred_subdomain = request()->get('subdomain');
        $user_profile->save();

        $res = (new SubscribeDemo($user_profile))->handle();

        if ($res->isError()) {
            return $this->jsonError($res);
        }

        return $this->jsonSuccess('', [
            'redirect'  => $res->data('tenants')->domains()->first()->domain
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
