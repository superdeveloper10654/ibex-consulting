<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationSetting extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'notification_settings';

    protected $guarded = [
        'id',

    ];
    protected $fillable = [
        'name',
        'slug',
        'value',
    ];
}
