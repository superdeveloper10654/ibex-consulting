<?php

namespace AppCentralAdmin\Http\Controllers;

use App\Http\Actions\Billing\SubscribeDemo;
use App\Models\Profile;
use AppTenant\Models\Profile as TenantProfile;
use App\Models\Statical\Constant;
use AppTenant\Models\Activity;
use AppTenant\Models\Programme;
use App\Models\Tenant;
use App\ThirdApi\Cloudflare;
use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Stancl\Tenancy\Features\UserImpersonation;

class TenantsController extends AdminBaseController
{
    /**
     * Display tenants list
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::latest()->paginate(config('app.pagination_size'));

        foreach ($tenants as $tenant) {
            $data = $tenant->run(function() {
                $last_activity = Activity::latest()->first();

                return [
                    'has_demo_subscription'     => admin_profile() ? admin_profile()->hasDemoSubscription() : false,
                    'has_paid_subscription'     => admin_profile() ? admin_profile()->hasPaidSubscription() : false,
                    'last_activity_created_at'  => $last_activity ? $last_activity->created_at->diffForHumans() : '',
                    'projects_count'            => Programme::count(),
                    'team_users_count'          => admin_profile() ? admin_profile()->team_users_count : 0,
                ];
            });
            
            foreach ($data as $key => $value) {
                $tenant->$key = $value;
            }
        }

        return ca_view('tenants.index', [
            'tenants'    => $tenants
        ]);
    }

    /**
     * Display tenant create page
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return ca_view('tenants.create', [
            'subscriptions' => Constant::activeSubscriptions(),
        ]);
    }

    /**
     * Create tenant profile
     * @param \Illuminate\Http\Request $request 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subscription_ids = implode(',', array_keys(Constant::activeSubscriptions()));

        $request->validate([
            'admin_first_name'          => 'required|string|max:255',
            'admin_last_name'           => 'required|string|max:255',
            'organisation'              => 'required|string|max:255',
            'admin_email'               => 'required|string|email|max:255|unique:profiles,email',
            'admin_account_password'    => 'required|string|min:6|confirmed',
            'admin_profile_avatar'      => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'subscription'              => "required|in:$subscription_ids",
            'tenant_subdomain'          => "required|max:63|regex:/^([a-zA-Z0-9][a-zA-Z0-9-_]*)/i"
        ]);

        $post = request()->all();

        if (isProduction()) {
            $record_name = $post['tenant_subdomain'] . '.' . FacadesRequest::getHost();
            $domain_record_exists = Cloudflare::instance()->isTenantDnsRecordExists($record_name);

            if ($domain_record_exists) {
                return $this->jsonError('Such subdomain already exists');
            }
        }

        $avatar = request()->file('admin_profile_avatar');
        $avatarName = time() . '-' . $avatar->getClientOriginalName() . '.' . $avatar->getClientOriginalExtension();
        $avatarPath = config('path.images.profiles');
        $avatar->move($avatarPath, $avatarName);
        
        $profile = Profile::create([
            'first_name'            => $post['admin_first_name'],
            'last_name'             => $post['admin_last_name'],
            'organisation'          => $post['organisation'],
            'email'                 => $post['admin_email'],
            'password'              => Hash::make($post['admin_account_password']),
            'avatar'                => config('path.images.profiles') . "/" . $avatarName,
            'department'            => Department::COMMERCIAL_ID,
            'role'                  => Role::ADMIN_ID,
            'team_users_count'      => env('TEAM_USERS_COUNT_MIN'),
            'preferred_subdomain'   => $post['tenant_subdomain'],
        ]);

        if ($post['subscription'] == Constant::SUBSCRIPTION_DEMO) {
            $res = (new SubscribeDemo($profile))->handle();
        } else {
            return $this->jsonError('Subscription not found');
        }

        return $this->jsonResponse($res);
    }

    /**
     * Delete tenant and all data
     * @param string $id of tenant
     * @return \Illuminate\Http\Response
     */
    function delete($id)
    {
        Tenant::findOrFail($id)->delete();

        return $this->jsonSuccess('Deleted');
    }

    /**
     * Login on tenant instance
     * @param string $id of tenant
     * @return \Illuminate\Http\Response
     */
    function loginAsAdmin($id)
    {
        $res = Tenant::findOrFail($id)->run(function() {
            $admin_profile = TenantProfile::where('email', env('SUPPORT_PROFILE_EMAIL'))->first();

            if (!$admin_profile) {
                return false;
            }

            $g = t_guard()->name;
            $token = tenancy()->impersonate(tenant(), $admin_profile->id, 'dashboard', $g);
            UserImpersonation::$ttl = 5; 

            return t_route('impersonate', $token);;
        });

        if (!$res) {
            return $this->jsonError([
                'Admin profile not found',
            ]);
        }

        return $this->jsonSuccess('', [
            'redirect'  => $res,
        ]);
    }
}