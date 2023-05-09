<?php

namespace AppCentralAdmin\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;

class AdminProfile extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'avatar',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* Model attributes */

    /**
     * @return string User name
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Admin avatar url
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return URL::asset('/assets/images/svg/profile-image.svg');
    }
}