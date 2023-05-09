<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TscContract extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'tsc_contracts';

    // protected $casts = [
    //     'share_assesed_on' => 'array'
    // ];

    protected $fillable = [
        'id',
        'contract_id',

        // step9

    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }

    public function serviceManager()
    {
        return $this->belongsTo('AppTenant\Models\Profile', 'sm_name_is', 'id');
    }

    public function getServiceManagerNameAttribute()
    {
        $sm = $this->serviceManager;
        return $sm ? $sm->name : $this->attributes['sm_name_is'];
    }
}
