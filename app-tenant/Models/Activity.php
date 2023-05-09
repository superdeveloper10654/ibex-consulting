<?php

namespace AppTenant\Models;

use AppTenant\Events\ActivityCreated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Activity extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'activity';

    protected $fillable = [
        'profile_id',
        'text',
        'img',
        'link',
        'resource',
        'resource_id',
        'allowed_roles',
        'allowed_department',
    ];

    public $timestamps = ["created_at"];
    public $casts = [
        'allowed_roles' => 'array',
    ];
    const UPDATED_AT = null;

    /**
     * Profile relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Add new activity
     *
     * @param string $text
     * @param string $link
     * @param string $img
     * @param int|array $allowed_role for which activity will be showed (by-default null - all)
     * @param int $allowed_department for which activity will be showed (by-default null - all)
     * @param int $profile_id that triggered activity (by-default currrent auth user)
     * @param string $resource class name
     * @param int $resource_id
     */
    public static function add($text, $link = null, $img = null, $allowed_role = null, $allowed_department = null, $profile_id = null, $resource = null, $resource_id = null)
    {
        $img = is_null($img) ? '<i class="mdi mdi-exclamation-thick" style="color: #f46a6a"></i>' : $img;
        $profile_id = !$profile_id ? t_profile()->id : $profile_id;

        if ($allowed_role !== null) {
            $allowed_role = is_array($allowed_role) ? $allowed_role : [$allowed_role];
        }

        $activity = static::create([
            'profile_id'            => $profile_id,
            'text'                  => $text,
            'img'                   => $img,
            'link'                  => $link,
            'resource'              => $resource,
            'resource_id'           => $resource_id,
            'allowed_roles'         => $allowed_role,
            'allowed_department'    => $allowed_department,
        ]);

        if ($activity) {
            ActivityCreated::dispatch($activity);
        }
    }

    /**
     * Add activity for resource
     * @param string $action
     * @param BaseModel $resource
     * @param int|array $allowed_role
     * @param int $allowed_department
     */
    public static function resource($action, $resource, $allowed_role = null, $allowed_department = null)
    {
        $text = "$action {$resource::resourceName()} #{$resource->id}";
        $resource_link = $resource->link('show', false);

        if (empty($resource_link)) {
            $resource_link = $resource->link('', false);
        }

        if (empty($resource_link)) {
            Log::alert('Activity link for resource not exists: ' . $resource::class);
        }
        static::add($text, $resource_link, $resource::$activity_icon, $allowed_role, $allowed_department, null, $resource::class, $resource->id);
    }

    /**
     * Get activities that visible for current user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $q
     * @return void
     */
    public function scopeVisibleForCurrentUser(Builder $q)
    {
        if (!t_profile()->isSuperAdmin() && !t_profile()->isAdmin()) {
            $q->where(function($q) {
                $q->whereNull('allowed_roles')
                    ->orWhereJsonContains('allowed_roles', t_profile()->role);
            })->where(function($q) {
                $q->whereNull('allowed_department')
                    ->orWhere('allowed_department', t_profile()->department);
            });
        }
    }
}
