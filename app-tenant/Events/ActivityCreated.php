<?php

namespace AppTenant\Events;

use AppTenant\Custom\Broadcast as TenantBroadcast;
use AppTenant\Models\Activity;
use AppTenant\Models\Statical\Format;
use AppTenant\Services\Helper;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Activity */
    public $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function broadcastAs()
    {
        return 'activity.created';
    }

    public function broadcastOn()
    {
        $team_profiles = Helper::teamProfilesWithSupport();
        $channels = [];

        $team_profiles->map(function($profile) use(&$channels) {
            if (!$profile->isSuperAdmin()) {
                if (!empty($this->activity->allowed_roles) && !in_array($profile->role, $this->activity->allowed_roles)) {
                    return;
                }
    
                if (!empty($this->activity->allowed_department) && $this->activity->allowed_department !== $profile->department) {
                    return;
                }
            }

            $channel_name = TenantBroadcast::generateChannelName('profile', tenant('uuid'), $profile->uuid);
            $channels[] = new PrivateChannel($channel_name);
        });

        return $channels;
    }

    public function broadcastWith()
    {
        return [
            'author_profile_id' => $this->activity->profile->id,
            'author'            => $this->activity->profile->name,
            'date'              => $this->activity->created_at->format(Format::DATE_WITH_TIME_READABLE),
            'text'              => $this->activity->text,
            'img'               => $this->activity->img,
            'link'              => $this->activity->link,
        ];
    }
}