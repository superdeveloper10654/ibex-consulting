<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spark\Billable;

class Profile extends Authenticatable
{
    use Billable, HasFactory, SoftDeletes;

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
        'preferred_subdomain',
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

    /* Model attributes */

    /**
     * @return string User name
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($profile) {
            
        });

        static::creating(function($profile) {
            $profile->uuid = Str::uuid()->toString();
        });
    }
}
