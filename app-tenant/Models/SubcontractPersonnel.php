<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcontractPersonnel extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'subcontract_personnel';

    protected $fillable = [
        'name',
        'role',
        'subbie_name',
    ];
}
