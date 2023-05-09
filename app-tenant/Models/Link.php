<?php
 
namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'source',
        'target',
        'tag',
    ];
}
