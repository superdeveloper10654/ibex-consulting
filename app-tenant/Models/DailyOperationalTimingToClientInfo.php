<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyOperationalTimingToClientInfo extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_operational_timing_to_client_infos';

    protected $fillable = [
        'daily_work_record_id',
        'demoblished_or_offsite',
        'informed_client',
        'comments'
    ];
}
