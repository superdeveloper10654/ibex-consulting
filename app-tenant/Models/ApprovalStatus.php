<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalStatus extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'approval_statuses';

    protected $guarded = [
        'id',

    ];
    protected $fillable = [
        'name',
        'slug',
    ];

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'status', 'id');
    }
}
