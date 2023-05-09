<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailySiteRisk extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'daily_site_risks';

    protected $fillable = [
        'daily_work_record_id',
        'description_of_issue',
    ];
}
