<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category',
        'data',
    ];
}
