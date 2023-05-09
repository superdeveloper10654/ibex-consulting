<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailySubContractClientOperation extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'daily_sub_contract_client_operations';

    protected $fillable = [
        'daily_work_record_id',
        'subcontract_or_client_operation_id',
        'operation_id',
        'comments'
    ];
    public function subcontractOrClientOperation()
    {
        return $this->belongsTo('AppTenant\Models\SubcontractOrClientOperation', 'subcontract_or_client_operation_id');
    }
    public function operation()
    {
        return $this->belongsTo('AppTenant\Models\Operation', 'operation_id');
    }
}
