<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceList extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'price_lists';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id',
        'contract_id',
        'item',
        'quantity',
        'unit',
        'price',
        'rate',
    ];
}
