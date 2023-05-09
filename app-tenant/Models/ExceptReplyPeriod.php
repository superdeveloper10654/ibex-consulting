<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExceptReplyPeriod extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'except_reply_periods';

    protected $fillable = [
        'contract_id',
        'reply_for',
        'reply_is',
        'is_by_sub_contractor',
    ];

    public function contract()
    {
        return $this->belongsTo('AppTenant\Models\Contract');
    }

    public function nec4TscContract()
    {
        return $this->belongsTo('AppTenant\Models\Nec4TscContract', 'contract_id', 'id');
    }
}
