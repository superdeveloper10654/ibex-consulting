<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class user_programme_link extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'user_id';


    protected $fillable = [
        'user_id',
        'date_range_start',
      	'programme_id',
        'date_range_end',
    ];
}
