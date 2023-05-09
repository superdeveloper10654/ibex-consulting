<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllTask extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'task_id',
        'column_id',
        'order_id',
        'progress', 
    ];

    /**
     * Task relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
