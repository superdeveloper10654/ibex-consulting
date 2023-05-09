<?php

namespace AppTenant\Models;

use App\Models\Statical\Constant;
use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Statical\Role;
use AppTenant\Services\Helper;
use BeyondCode\Comments\Contracts\Commentator;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spark\Billable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class Profile extends Authenticatable implements Commentator, HasMedia
{
    use Billable, HasFactory, HasRoles, Notifiable, SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
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
        'receipt_emails',
        'role',
        'team_users_count',
        'trial_ends_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'uuid',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'trial_ends_at'     => 'datetime',
    ];

    protected $appends = [
        'address'
    ];
    /** @var array Cached items for attributes */
    protected $cached_attrs = [];

    /**
     * @return string Profile avatar url (or if empty - placeholder avatar url)
     */
    public function avatar_url()
    {
        if (isset($this->avatar) && $this->avatar != "") {
            if (Storage::disk('public')->exists(config('path.images.profiles') . $this->avatar)) {
                return tenant_asset(config('path.images.profiles') . '/' . $this->avatar);
            } else if (file_exists(public_path($this->avatar))) {
                return asset($this->avatar);
            } else {
                $name = explode('/', $this->avatar);
                return asset(config('path.images.profiles') . end($name));
            }
        } else {
            return asset('/assets/images/companies/img-5.png');
        }
    }

    /**
     * @return string User full name
     */
    public function full_name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Department object
     *
     * @return object<id,value>
     */
    public function department()
    {
        return Department::get($this->department);
    }

    /**
     * Contracts query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function contracts()
    {
        if ($this->isContractor()) {
            return Contract::where('profile_id', $this->id);
        } else  if($this->isSubcontractor()) {
            return Contract::where('subcontractor_profile_id', $this->id);
        } else {
            return Contract::query();
        }
    }

    /**
     * Contractor subcontractor relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcontractors()
    {
        return $this->hasMany(Profile::class, 'parent_id');
    }

    /**
     * Profile folders relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function folders()
    {
        return $this->hasMany(ProfileFolder::class);
    }

    /**
     * If the admin has Paid subsciption (not Demo)
     *
     * @return bool
     */
    public function hasPaidSubscription()
    {
        $admin_profile = $this->isAdmin() ? $this : admin_profile();
        $subscription = $admin_profile->subscription();

        return $admin_profile->isAdmin() && $admin_profile->subscribed() && $subscription->stripe_plan !== Constant::SUBSCRIPTION_DEMO;
    }

    /**
     * If the admin has Demo subsciption (not Paid)
     *
     * @return bool
     */
    public function hasDemoSubscription()
    {
        $admin_profile = $this->isAdmin() ? $this : admin_profile();
        $subscription = $admin_profile->subscription();

        return $admin_profile->isAdmin() && $admin_profile->subscribed() && $subscription->stripe_plan === Constant::SUBSCRIPTION_DEMO;
    }

    /**
     * Is user has role Admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role == Role::ADMIN_ID;
    }

    /**
     * Is user has role Contractor
     *
     * @return bool
     */
    public function isContractor()
    {
        return $this->role == Role::CONTRACTOR_ID;
    }

    /**
     * Is user has role Cubcontractor
     *
     * @return bool
     */
    public function isSubcontractor()
    {
        return $this->role == Role::SUBCONTRACTOR_ID;
    }

    /**
     * Is user has role Super Admin
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->role == Role::SUPER_ADMIN_ID;
    }

    /**
     * Is registered users limit exceed (by billing package)
     *
     * @throws Exception in case of user is not admin
     * @return bool
     */
    public function registeredUsersLimitReached()
    {
        if (!$this->isAdmin()) {
            throw new Exception('User is not admin.');
        }

        if (!isset($this->cached_attrs['registered_users_limit_reached'])) {
            if ($this->hasPaidSubscription()) {
                $this->cached_attrs['registered_users_limit_reached'] = Helper::teamProfiles()->count() >= $this->team_users_count;
            } else {
                $this->cached_attrs['registered_users_limit_reached'] = Helper::teamProfiles()->count() >= env('TEAM_USERS_COUNT_DEMO');
            }
        }

        return $this->cached_attrs['registered_users_limit_reached'];
    }

    /**
     * Role object
     *
     * @return object<id,value>
     */
    public function role()
    {
        return Role::get($this->role);
    }


    /* Services/Third-party libs methods  */

    /**
     * Check if a comment needs to be approved.
     *
     * @param mixed $model
     * @return bool
     */
    public function needsCommentApproval($model): bool
    {
        return false;
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $collections = MediaCollection::getAll();

        foreach ($collections as $collection) {
            $this->addMediaCollection($collection);
        }

        foreach ($this->folders as $folder) {
            $this->addMediaCollection($folder->folder_name);
        }
    }


    /* Model attributes */

    /**
     * @return string User name
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return string Organisation logo link
     */
    public function getOrganisationLogoLinkAttribute()
    {
        return !empty($this->organisation_logo) ? tenant_asset(config('path.files.settings') . '/' . $this->organisation_logo) : '';
    }

    public function getAddressAttribute()
    {
        return $this->billing_address .
            $this->billing_address_line_2 .
            $this->billing_city .
            $this->billing_state .
            $this->billing_postal_code .
            $this->billing_country;
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function($profile) {
            if (!empty($profile->avatar)) {
                Storage::disk('public')->delete(config('path.images.profiles') . $profile->avatar);
            }
        });

        static::creating(function($profile) {
            $profile->uuid = Str::uuid()->toString();
        });
    }
}
