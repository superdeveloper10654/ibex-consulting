<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcontractOrClientOperation extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'subcontract_or_client_operations';

    protected $fillable = [
        'subbie_name',
        'operation_name',
    ];
}
