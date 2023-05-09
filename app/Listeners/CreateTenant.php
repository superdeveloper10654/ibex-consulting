<?php

namespace App\Listeners;

use App\Models\Profile;
use App\Models\Tenant;
use App\ThirdApi\Cloudflare;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Spark\Events\SubscriptionCreated;

class CreateTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Spark\Events\SubscriptionCreated  $event
     * @return void
     */
    public function handle(SubscriptionCreated $event)
    {
        $profile = Profile::find($event->billable->id);
        $subdomain = $profile->preferred_subdomain;
        $domain = $subdomain . '.' . Request::getHost();

        if (isProduction()) {
            if (env('CLOUDFLARE_ZONE') && env('CLOUDFLARE_IP') && env('CLOUDFLARE_AUTH_EMAIL') && env('CLOUDFLARE_AUTH_KEY')) {
                $cloudflare = Cloudflare::instance();
                $res = $cloudflare->addTenantDnsRecord($domain);

                if (!$res->success) {
                    $errors = implode('; ', $res->errors);
                    $messages = implode('; ', $res->messages);
                    throw new Exception("Error during setup tenant DNS records. Errors: $errors. Messages: $messages");
                }
            } else {
                throw new Exception('Please configure Cloudflare env variables to properly setup tenant.');
            }
        }

        $tenant = Tenant::create([
            'admin_profile_id'  => $profile->id,
            'id'                => $subdomain,
            'uuid'              => Str::uuid()->toString(),
        ]);
        $tenant->domains()->create(['domain' => $domain]);
    }
}
