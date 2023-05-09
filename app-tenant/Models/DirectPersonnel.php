<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DirectPersonnel extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'direct_personnel';

    protected $fillable = [
        'name',
        'role',
    ];
}
