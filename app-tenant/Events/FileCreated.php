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
use Illuminate\Support\Facades\Log;

class FileCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var BeyondCode\Comments\Comment */
    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function broadcastAs()
    {
        $folder = $this->file->collection_name;
        
        return "file.created.{$folder}";
    }

    public function broadcastOn()
    {
        $team_profiles = Helper::teamProfilesWithSupport();
        $model_name = Helper::getUploadsClassForFile($this->file);
        $permission = $model_name::permission('read');
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
        $file = $this->file->only(['id', 'file_name', 'created_at', 'mime_type', 'human_readable_size']);
        $file['link'] = t_route('uploads.download', $file['id'], false);
        $file['created_at'] = date(Format::DATE_WITH_TIME_READABLE, strtotime($file['created_at']));

        return $file;
    }
}