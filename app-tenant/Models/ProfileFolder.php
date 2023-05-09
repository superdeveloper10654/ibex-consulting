<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileFolder extends BaseModel
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'profile_id',
        'folder_name'
    ];
}
