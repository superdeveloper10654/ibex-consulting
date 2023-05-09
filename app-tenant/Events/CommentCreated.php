<?php

namespace AppTenant\Events;

use AppTenant\Custom\Broadcast as TenantBroadcast;
use AppTenant\Models\Statical\Format;
use AppTenant\Services\Helper;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var BeyondCode\Comments\Comment */
    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function broadcastAs()
    {
        $name = $this->comment->commentable_type::resourceNameDashed();
        $id = $this->comment->commentable_id;

        return "comment.created.{$name}.{$id}";
    }

    public function broadcastOn()
    {
        $team_profiles = Helper::teamProfilesWithSupport();
        $resource_class = $this->comment->commentable_type;
        $permission = $resource_class::permission('read');
        $channels = [];

        $team_profiles->map(function($profile) use(&$channels, $permission) {
            if (!$profile->isSuperAdmin()) {
                if (!$profile->can($permission)) {
                    return ;
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
            'author_profile_id' => $this->comment->commentator->id,
            'author'            => $this->comment->commentator->name,
            'icon_url'          => $this->comment->commentator->avatar_url(),
            'date'              => $this->comment->created_at->format(Format::DATE_WITH_TIME_READABLE),
            'text'              => $this->comment->comment,
        ];
    }
}