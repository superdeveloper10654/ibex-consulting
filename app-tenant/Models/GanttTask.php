<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GanttTask extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'gantt_tasks';

    protected $fillable = [
        "id",
        "guid",
        "programme_id",
        "text",
        "start_date",
        "end_date",
        "duration",
        "baseline_start",
        "baseline_end",
        "deadline",
        "progress",
        "parent",
        "sortorder",
        "type",
        "resource_id",
        "resource_group_id",
        "calendar_id",
        "comment",
        "is_summary",
        "color",
    ];

    protected $casts = [];

    /**
     * Links relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function links()
    {
        return $this->hasMany(Link::class, 'source');
    }

    /**
     * Contract relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(GanttTask::class, 'parent', 'id');
    }

    public function subTasks()
    {
        return $this->hasMany(GanttTask::class, 'parent', 'id');
    }

    public function assignees()
    {
        return $this->belongsToMany(Profile::class, 'gantt_task_assignees', 'task_id', 'assignee_id');
    }

    public static function boot()
    {
        parent::boot();

        static::forceDeleting(function ($task) {
            $task->links->each(function ($link) {
                $link->forceDelete();
            });
        });
    }    
}
