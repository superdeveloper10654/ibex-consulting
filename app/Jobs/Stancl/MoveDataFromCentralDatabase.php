<?php

declare(strict_types=1);

namespace App\Jobs\Stancl;

use App\Events\Stancl\CentralDatabaseDataMovedToTenant;
use AppTenant\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spark\TaxRate;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class MoveDataFromCentralDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var TenantWithDatabase|Model */
    protected $tenant;

    /** @var App\Models\Profile */
    protected $user_profile;

    public function __construct(TenantWithDatabase $tenant)
    {
        $this->tenant = $tenant;
        $this->user_profile = Auth::user();
    }

    public function handle()
    {
        $user_profile_tenant = Profile::with('subscriptions', 'subscriptions.items')->find($this->tenant->admin_profile_id);
        $tax_rates = TaxRate::all();

        $this->tenant->run(function () use ($user_profile_tenant, $tax_rates) {
            DB::beginTransaction();

            $user_profile_arr = $user_profile_tenant->toArray();
            $user_profile_arr = collect($user_profile_arr)->only([
                'card_brand',
                'card_last_four',
                'card_expiration',
                'extra_billing_information',
                'billing_address',
                'billing_address_line_2',
                'billing_city',
                'billing_state',
                'billing_postal_code',
                'billing_country',
                'first_name',
                'last_name',
                'email',
                'password',
                'phone',
                'dob',
                'avatar',
                'department',
                'organisation',
                'organisation_logo',
                'preferred_subdomain',
                'role',
                'team_users_count',
                'trial_ends_at',
            ])->toArray();
            $user_profile_arr['password'] = $user_profile_tenant->password;
            $user_profile_copy = Profile::create($user_profile_arr);

            $subscription_copy = $user_profile_tenant->subscriptions->first()->replicate();
            $subscription_copy->profile_id = $user_profile_copy->id;
            $subscription_copy->save();

            $subscription_item_copy = $user_profile_tenant->subscriptions->first()->items->first()->replicate();
            $subscription_item_copy->subscription_id = $subscription_copy->id;
            $subscription_item_copy->save();

            $tax_rates->each(function ($rate) {
                $rate_copy = $rate->replicate();
                $rate_copy->save();
            });

            DB::commit();
        });

        DB::delete("DELETE FROM " . $user_profile_tenant->getTable() . " WHERE id = ?", [$user_profile_tenant->id]);

        event(new CentralDatabaseDataMovedToTenant($this->tenant));
    }
}
