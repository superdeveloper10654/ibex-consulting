<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Notification extends BaseModel
{
    use HasFactory, SoftDeletes;

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
     * Add new notification
     * 
     * @param string $text
     * @param string $link
     * @param string $img
     * @param int|array $allowed_roles for which notification will be shown
     * @param int $profile_id that triggered notification
     * @param string $resource class name
     * @param string $resource_id
     */
    public static function add($text, $link = '', $img = '<i class="mdi mdi-exclamation-thick" style="color: #f46a6a"></i>', $allowed_roles = null, $allowed_department = null, $profile_id = null, $resource = null, $resource_id = null)
    {
       $profile_id = !$profile_id ? t_profile()->id : $profile_id;
       $allowed_roles = is_array($allowed_roles) ? $allowed_roles : [$allowed_roles];

       static::create([
            'profile_id'            => $profile_id,
            'text'                  => $text,
            'img'                   => $img,
            'link'                  => $link,
            'resource'              => $resource,
            'resource_id'           => $resource_id,
            'allowed_roles'         => $allowed_roles,
            'allowed_department'    => $allowed_department,
       ]);
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
        static::add($text, $resource->link('show', false), $resource::$activity_icon, $allowed_role, $allowed_department, null, $resource::class, $resource->id);
    }

    /**
     * Dismiss notification for profile
     * 
     * @param int $profile_id
     */
    public function dismiss($profile_id)
    {
        $res = DB::selectOne('SELECT * FROM profiles_notified WHERE profile_id = ? AND notification_id = ?', [$profile_id, $this->id]);

        if (!empty($res)) {
            return 'Already dismissed';
        }

        DB::insert('INSERT INTO profiles_notified (profile_id, notification_id, created_at) VALUES (?, ?, ?)', [$profile_id, $this->id, date('Y-m-d H:i:s')]);

        return true;
    }
}
