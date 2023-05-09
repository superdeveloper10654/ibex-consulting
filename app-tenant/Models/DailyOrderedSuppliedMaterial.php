<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyOrderedSuppliedMaterial extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'daily_ordered_supplied_materials';

    protected $fillable = [
        'daily_work_record_id',
        'material_id',
        'prog',
        'on_site',
        'supplied',
        'comments'
    ];
    public function material()
    {
        return $this->belongsTo('AppTenant\Models\Material', 'material_id');
    }
}
