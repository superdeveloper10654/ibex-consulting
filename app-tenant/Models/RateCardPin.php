<?php

namespace AppTenant\Models;

use AppTenant\Models\Statical\RateCardUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class RateCardPin extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'rate_card_unit',
        'icon',
        'line_color',
        'line_type',
        'fill_color',
    ];

    protected $appends = ['html', 'icon_url'];

    /**
     * Rate Cards relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function rate_cards()
    {
        return $this->hasMany(RateCard::class, 'pin_id');
    }

    /**
     * Set unit id to unit string
     *
     * @return integer
     */
    public function getUnitAttribute()
    {
        return RateCardUnit::get($this->rate_card_unit);
    }

    /**
     * Creates html for pin icon
     *
     * @return string
     */
    public function getHtmlAttribute()
    {
        if ($this->rate_card_unit == RateCardUnit::ITEM_ID) {
            $res = "<img class='rate-card-icon item' src='" . $this->icon_url . "' width='50' />";

        } else if ($this->rate_card_unit == RateCardUnit::LINE_ID) {
            $res = '<div class="rate-card-icon line" height="3" style="border-bottom: 5px '.$this->line_type.' '.$this->line_color.';width:30px;display:inline-block;"></div>';

        } else if ($this->rate_card_unit == RateCardUnit::POLYGON_ID) {
            $res = '<div class="rate-card-icon" style="background-color:' . $this->fill_color . ';width:17px;height:17px;display:inline-block;"></div>';
        }

        return $res;
    }

    /**
     * Icon url
     * 
     * @return string
     */
    public function getIconUrlAttribute()
    {
        return $this->icon ? tenant_asset(config("path.images.rate_cards.pins") . "/" . $this->icon) : null;
    }
}
