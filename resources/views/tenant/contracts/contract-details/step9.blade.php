@if(!str_contains($contractType,'NEC4'))
<h4 class="card-title mt-4 mb-3">Optional statements</h4>

@if(
str_starts_with($contractAppl->main_opt , 'Option C:')
||
(!str_contains($contractType,'TSC') && str_starts_with($contractAppl->main_opt , 'Option D:'))
)

<p class="mt-3">If Option C @if(!str_contains($contractType,'TSC')) or D @endif is used</p>
<ul class="mb-4">
    <li class="mb-3">The <i>{{str_contains($contractType,'ECS') ? 'Subcontractor': 'Contractor'}}’s share percentages </i> and the <i>share ranges</i> are
        <div class="row mt-2 align-items-top">
            <div class="col-lg-6 col-8">share range</div>
            <div class="col">{{str_contains($contractType,'ECS') ? 'Subcontractor': 'Contractor'}}’s share percentage</div>
            <div class="col-lg-6 col-8">
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">less than</span>
                    </div>
                    <div class="input-group-prepend col">
                        <input name="share_range_less_than" type="number" step="0.01" min="0" class="form-control" style="border-radius:0;" value="{{$contractAppl->share_range_less_than}}" required>
                    </div>
                    <label class="input-group-text px-1">%</label>
                </div>
                @error('share_range_less_than')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <div class="input-group mt-2">
                    <div class="input-group-prepend col">
                        <input name="less_than_share_percentage" type="number" step="0.01" min="0" class="form-control" style="border-top-right-radius:0;border-bottom-right-radius:0;" value="{{$contractAppl->less_than_share_percentage}}" required>
                    </div>
                    <label class="input-group-text px-1">%</label>
                </div>
                @error('less_than_share_percentage')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-lg-6 col-8">
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">from</span>
                    </div>
                    <div class="input-group-prepend col">
                        <input name="share_range_from_1" type="number" step="0.01" min="0" class="form-control" style="border-radius:0;" value="{{$contractAppl->share_range_from_1}}" required>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text px-1">%</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text">to</span>
                    </div>
                    <div class="input-group-prepend col">
                        <input name="share_range_to_1" type="number" step="0.01" min="0" class="form-control" style="border-radius:0;" value="{{$contractAppl->share_range_to_1}}" required>
                    </div>
                    <label class="input-group-text px-1">%</label>
                </div>
                @error('share_range_from_1')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                @error('share_range_to_1')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <div class="input-group mt-2">
                    <div class="input-group-prepend col">
                        <input name="from_to_share_percentage_1" type="number" step="0.01" min="0" class="form-control" style="border-top-right-radius:0;border-bottom-right-radius:0;" value="{{$contractAppl->from_to_share_percentage_1}}" required>
                    </div>
                    <label class="input-group-text px-1">%</label>
                </div>
                @error('from_to_share_percentage_1')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-lg-6 col-8">
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">from</span>
                    </div>
                    <div class="input-group-prepend col">
                        <input name="share_range_from_2" type="number" step="0.01" min="0" class="form-control" style="border-radius:0;" value="{{$contractAppl->share_range_from_2}}" required>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text px-1">%</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text">to</span>
                    </div>
                    <div class="input-group-prepend col">
                        <input name="share_range_to_2" type="number" step="0.01" min="0" class="form-control" style="border-radius:0;" value="{{$contractAppl->share_range_to_2}}" required>
                    </div>
                    <label class="input-group-text px-1">%</label>
                </div>
                @error('share_range_from_2')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                @error('share_range_to_2')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <div class="input-group mt-2">
                    <div class="input-group-prepend col">
                        <input name="from_to_share_percentage_2" type="number" step="0.01" min="0" class="form-control" style="border-top-right-radius:0;border-bottom-right-radius:0;" value="{{$contractAppl->from_to_share_percentage_2}}" required>
                    </div>
                    <label class="input-group-text px-1">%</label>
                </div>
                @error('from_to_share_percentage_2')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-lg-6 col-8">
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">greater than</span>
                    </div>
                    <div class="input-group-prepend col">
                        <input name="share_range_greater_than" type="number" step="0.01" min="0" class="form-control" style="border-radius:0;" value="{{$contractAppl->share_range_greater_than}}" required>
                    </div>
                    <label class="input-group-text px-1">%</label>
                </div>
                @error('share_range_greater_than')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <div class="input-group mt-2">
                    <div class="input-group-prepend col">
                        <input name="greater_than_share_percentage" type="number" step="0.01" min="0" class="form-control" style="border-top-right-radius:0;border-bottom-right-radius:0;" value="{{$contractAppl->greater_than_share_percentage}}" required>
                    </div>
                    <label class="input-group-text px-1">%</label>
                </div>
                @error('greater_than_share_percentage')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </li>
    @if(str_contains($contractType,'TSC'))
    <li class="mb-3">The <i>Contractor’s</i> share is assessed on (dates)
        <input type="text" name="share_assesed_on" class="form-control date" placeholder="Pick the multiple dates" value="{{$contractAppl->share_assesed_on}}" required>
        @error('share_assesed_on')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
</ul>
@endif

@if(
str_starts_with($contractAppl->main_opt, 'Option C:') || str_starts_with($contractAppl->main_opt ,'Option E:')
||
(!str_contains($contractType,'TSC') &&
(
str_starts_with($contractAppl->main_opt , 'Option D:')
||
(str_contains($contractType,'ECC') && str_starts_with($contractAppl->main_opt , 'Option F:'))
)
)
)
<p class="mt-3">
    If Option C
    @if(str_contains($contractType,'TSC'))
    or E
    @elseif(str_contains($contractType,'ECC'))
    , D , E or F
    @else
    , D or E
    @endif
    is used
</p>
<ul class="mb-4">
    <li class="mb-3">The <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i> prepares forecasts of the @if(str_contains($contractType,'TSC')) total @endif Defined Cost for the
        @if(str_contains($contractType,'TSC'))
        whole of the <i>service</i>
        @else
        <i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i>
        @endif
        at intervals no longer than
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input name="max_prepare_forcast_week_interval" type="number" step="1" min="1" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0; width: 100px;" value="{{$contractAppl->max_prepare_forcast_week_interval}}" required>
            </div>
            <label class="input-group-text">weeks</label>
        </div>
        @error('max_prepare_forcast_week_interval')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">
        The <i>exchange rates</i> are those published in
        <div class="input-group mt-2">
            <input class="form-control" type="text" name="exchange_rates_text" value="{{$contractAppl->exchange_rates_text}}" required>
            <div class="input-group-append">
                <span class="input-group-text">on</span>
            </div>
            <div class="input-group-append">
                <input class="form-control" type="date" name="exchange_rates_date" style="width: 220px;" value="{{$contractAppl->exchange_rates_date}}" required>
            </div>
            <div class="input-group-append">
                <span class="input-group-text">(date)</span>
            </div>
        </div>
        @error('exchange_rates_text')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        @error('exchange_rates_date')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@endif



@if($contractAppl->sec_opt_X1)

@if(!str_contains($contractType,'NEC4') ||
(
(str_starts_with($contractAppl->main_opt , 'Option A:') || str_starts_with($contractAppl->main_opt,'Option C:'))
||
(!str_contains($contractType,'TSC') && (str_starts_with($contractAppl->main_opt , 'Option B:') || str_starts_with($contractAppl->main_opt , 'Option D:')))
)
)

@if(str_contains($contractType,'NEC4'))
<h4 class="card-title mt-4 mb-3">X1: Price adjustment for inflation (used only with Option A {{str_contains($contractType,'TSC') ? 'and C' : ', B , C and D'}})</h4>
@endif
<p class="mt-3">If Option X1 is used</p>
<ul class="mb-4">
    <li class="mb-3">The proportions used to calculate the Price Adjustment Factor are
        <div id="price-adjustment-factors">

        </div>
        <div class="col-md-11">
            <input name="paf[0][id]" value="{{$nonAdjustablePriceAdjustmentFactor->id}}" hidden>
            <input name="paf[0][contract_id]" value="{{$id}}" hidden>
            <input name="paf[0][is_non_adjustable]" value="{{$nonAdjustablePriceAdjustmentFactor->is_non_adjustable}}" hidden>
            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <input name="paf[0][proportion]" type="number" step="0.01" min="0" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0; width: 100px;" value="{{$nonAdjustablePriceAdjustmentFactor->proportion}}" required>
                </div>
                <div class="input-group-prepend">
                    <span class="input-group-text">non adjustable</span>
                </div>
                @if(str_contains($contractType,'NEC4'))
                <input name="paf[0][factor]" type="text" value="{{$nonAdjustablePriceAdjustmentFactor->factor}}" class="form-control" required>
                @endif
            </div>
        </div>
        @error('paf')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_add_price_adj" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
        </div>
    </li>
</ul>
<ul class="mb-4">
    <li class="mb-3">The <i>base date</i> for indices is
        <input class="form-control mt-2" type="date" id="base_date" name="base_date" style="width: 220px;" value="{{$contractAppl->base_date}}" required>
        @error('base_date')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @if($contractType=='NEC4_TSC')
    <li class="mb-3">The <i>inflation adjustment dates</i> are
        <input type="text" name="inflation_adjustment_dates" class="form-control date" placeholder="Pick the multiple dates" value="{{$nec4Contract->inflation_adjustment_dates}}" required>
        @error('inflation_adjustment_dates')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    <li class="mb-3">These indices are @if(!str_contains($contractType,'NEC4')) those prepared by @endif
        <input class="form-control mt-2" type="text" id="indices_prepared_by" name="indices_prepared_by" value="{{$contractAppl->indices_prepared_by}}" required>
        @error('indices_prepared_by')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>

@endif

@endif

@if($contractAppl->sec_opt_X3)

@if(!str_contains($contractType,'NEC4') ||
(str_starts_with($contractAppl->main_opt , 'Option A:') ||
(!str_contains($contractType,'TSC') && str_starts_with($contractAppl->main_opt , 'Option B:') )
)
)

@if(str_contains($contractType,'NEC4'))
<h4 class="card-title mt-4 mb-3">X3: Multiple currencies (used only with Option A @if(!str_contains($contractType,'TSC')) and B @endif)</h4>
@endif
<p class="mt-3">If Option X3 is used</p>
<ul class="mb-4">
    <li class="mb-3">The <i>{{str_contains($contractType,'ECS') ? 'Contractor': (str_contains($contractType,'NEC4') ? 'Client':'Employer')}}</i> will pay for the items or activities listed below in the currencies stated
        <div class="col-md-11">
            <div class="input-group mt-2">
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    items and activities
                </div>
                <div class="col-md-3 px-3">
                    other currency
                </div>
                <div class="col-md-5">
                    total maximum payment in the othe currecy
                </div>
            </div>
        </div>
        <div id="pay-items">

        </div>

    </li>
    <div class="my-2 d-flex justify-content-end col-md-11">
        <button type="button" id="btn_add_item" class="btn btn-sm btn-primary mb-2"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
    <li class="mb-3">The <i>exchange rates</i> are those published in
        <div class="input-group mt-2">
            <input class="form-control" type="text" name="x3_exchange_rates_text" value="{{$contractAppl->x3_exchange_rates_text}}" required>
            <div class="input-group-prepend">
                <span class="input-group-text">on</span>
            </div>
            <div class="input-group-prepend">
                <input class="form-control" type="date" name="x3_exchange_rates_date" style="width: 220px;" value="{{$contractAppl->x3_exchange_rates_date}}" required>
            </div>
            <div class="input-group-append">
                <span class="input-group-text">(date)</span>
            </div>
        </div>
        @error('x3_exchange_rates_text')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        @error('x3_exchange_rates_date')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>

@endif

@endif

@if(!str_contains($contractType,'TSC'))

@if($contractAppl->sec_opt_X5)
@if(str_contains($contractType,'NEC4'))
<h4 class="card-title mt-4 mb-3">X5: Sectional Completion</h4>
@endif
<p class="mt-3">If Option X5 is used</p>
<ul class="mb-4">
    <li class="mb-3">The <i>@if(str_contains($contractType,'ECS')) subcontract @endif completion date</i> for each <i>section</i> of the <i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i> is
        <div class="row mt-2 col-md-11">
            <p class="col-md-2"><i>section</i></p>
            <p class="col-md-7"> description</p>
            <p class="col-md-3"><i>@if(str_contains($contractType,'ECS')) subcontract @endif completion date</i></p>
        </div>
        <div id="completion-dates">

        </div>
    </li>
    <div class="my-2 d-flex justify-content-end col-md-11">
        <button type="button" id="btn_add_completion_date" class="btn btn-sm btn-primary float-right"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
</ul>
@endif


@if(str_contains($contractType,'NEC4'))
@if($contractAppl->sec_opt_X6)
<h4 class="card-title mt-4 mb-3">X6: Bonus for early Completion</h4>
@if(!$contractAppl->sec_opt_X5)
<p class="mt-3">If Option X6 is used without X5</p>
<ul class="mb-4">
    <li class="mb-3">The bonus for the of the <i>@if(str_contains($contractType,'ECS')) whole of the subcontract @endif works</i> is
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="x6_bonus_number" value="{{$contractAppl->x6_bonus_number}}" style="width: 100px;" required>
            </div>
            <label class="input-group-text">per day.</label>
        </div>
        @error('x6_bonus_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
@endif
@endif

@if($contractAppl->sec_opt_X5 && $contractAppl->sec_opt_X6)
<p class="mt-3">{{str_contains($contractType,'NEC4') ? 'If Option X6 is used with Option X5':'If Options X5 and X6 are used together'}}</p>
<ul class="mb-4">
    <li class="mb-3">The bonus for each <i>section</i> of the <i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i> is
        <div class="row mt-2 col-md-11">
            <p class="col-md-3"><i>section</i></p>
            <p class="col-md-6"> description</p>
            <p class="col-md-3" style="text-align: right">amount per day</p>
        </div>
        <div id="bonuses">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_add_bonus" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
        </div>
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <span class="input-group-text">{{str_contains($contractType,'NEC4') ? 'The bonus for the r':' R'}}emainder of the&nbsp;<i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i></span>
            </div>
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="bonus_remainder_number" style="width: 100px; border-bottom-left-radius: 0; border-top-left-radius: 0;" value="{{$contractAppl->bonus_remainder_number}}" required>
            </div>
        </div>
        @error('bonus_remainder_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@if($contractAppl->sec_opt_X7)
@if(str_contains($contractType,'NEC4'))<h4 class="card-title mt-4 mb-3">X7: Delay damages</h4>@endif
@if($contractAppl->sec_opt_X5)
<p class="mt-3">If Options X5 and X7 are used together</p>
<ul class="mb-4">
    <li class="mb-3">Delay damages for each <i>section</i> of the <i>works</i> are
        <div class="row mt-2 col-md-11">
            <p class="col-md-3"><i>section</i></p>
            <p class="col-md-6"> description</p>
            <p class="col-md-3" style="text-align: right">amount per day</p>
        </div>
        <div id="delay-damages">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_add_delay_damage" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
        </div>

        <div class="input-group mt-2">
            <div class="input-group-prepend">
                @if(str_contains($contractType,'NEC4_ECS'))
                <span class="input-group-text">The delay damages for the remainder of the &nbsp;<i>subcontract works</i></span>
                @else
                <span class="input-group-text">Remainder of the&nbsp;<i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i></span>
                @endif
            </div>
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="delay_damages_remainder_number" style="width: 100px; border-bottom-left-radius: 0; border-top-left-radius: 0;" value="{{$contractAppl->delay_damages_remainder_number}}" required>
            </div>
        </div>
        @error('delay_damages_remainder_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
@endif

@if(!str_contains($contractType,'NEC4') && !$contractAppl->sec_opt_X5 && $contractAppl->sec_opt_X6)
<p class="mt-3">If Option X6 is used (but not if Option X5 is also used)</p>
<ul class="mb-4">
    <li class="mb-3">The bonus for the of the whole of the<i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i> is
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="x6_bonus_number" value="{{$contractAppl->x6_bonus_number}}" style="width: 100px;" required>
            </div>
            <label class="input-group-text">per day.</label>
        </div>
        @error('x6_bonus_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@if(!$contractAppl->sec_opt_X5 && $contractAppl->sec_opt_X7)
<p class="mt-3">{{str_contains($contractType,'NEC4') ? 'If Option X7 is used without Option X5':'If Option X7 is used (but not if Option X5 is also used)'}}</p>
<ul class="mb-4">
    <li class="mb-3">Delay damages for Completion of the whole of the<i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i> are
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="x7_delay_damages_number" value="{{$contractAppl->x7_delay_damages_number}}" style="width: 100px;" required>
            </div>
            <label class="input-group-text">per day.</label>
        </div>
        @error('x7_delay_damages_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@endif

@if(str_contains($contractType,'NEC4'))

@if($contractAppl->sec_opt_X8)
<h4 class="card-title mt-4 mb-3">X8: Undertakings to the <i>Client</i> or Others</h4>
<p class="mt-3">If Option X8 is used</p>
<ul class="mb-4">
    <li class="mb-3">The <i>Undertakings to </i> others are
        <div class="row mt-2 col-md-11">
            <p class="col-md-1"></p>
            <p class="col-md-11"> provided to</p>
        </div>
        <div id="to-others">

        </div>
        <div class="my-2 col-md-11 d-flex justify-content-end">
            <button type="button" id="btn_add_to_other" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
        </div>
    </li>
    @if(!str_contains($contractType,'ECS'))
    <li class="mb-3">The <i>Subcontractor Undertakings to </i> others are
        <div class="row mt-2 col-md-11">
            <div class="col-md-1">
            </div>
            <div class="col-md-6">
                <p class="mb-0">@if(str_contains($contractType,'ECS')) subcontract @endif works</p>
            </div>
            <div class="col-md-5">
                <p class="mb-0">provided to</p>
            </div>
        </div>
        <div id="sub-to-others">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_add_sub_to_other" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
        </div>
    </li>
    @endif
    <li class="mb-3">The <i>@if(!str_contains($contractType,'ECS')) Subcontractor @endif Undertakings to the client</i> are
        <div class="row mt-2 col-md-11">
            <p class="col-md-1"></p>
            <p class="col-md-11">@if(str_contains($contractType,'ECS')) subcontract @endif works</p>
        </div>
        <div id="to-clients">

        </div>
        <div class="my-2 d-flex col-md-11 justify-content-end">
            <button type="button" id="btn_add_to_client" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
        </div>
    </li>
</ul>
@endif
@if($contractAppl->sec_opt_X10)
<h4 class="card-title mt-4 mb-3">X10: Information modelling</h4>
<p class="mt-3">If Option X10 is used</p>
<p>If no <i>information execution
        plan</i> is identified in part
    two of the {{str_contains($contractType,'ECS') ? 'Subcontract':'Contract'}} Data</p>
<ul class="mb-4">
    <li class="mb-3">The period after the {{str_contains($contractType,'ECS') ? 'Subcontract':'Contract'}} Date within which the <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i> is to submit a first
        Information Execution Plan for acceptance is
        <input type="number" name="x10_info_exec_plan_period" class="form-control mt-2" rows="3" placeholder="" value="{{$nec4Contract->x10_info_exec_plan_period}}" required>
        @error('x10_info_exec_plan_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The minimum amount of insurance cover for claims made against the <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i> arising
        out of its failure to use the skill and care normally used by professionals providing
        information similar to the Project Information is,
        in respect of each claim
        <input type="number" name="x10_min_insurance_amount" class="form-control mt-2" rows="3" placeholder="" value="{{$nec4Contract->x10_min_insurance_amount}}" required>
        @error('x10_min_insurance_amount')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The period following @if(str_contains($contractType,'TSC')) the end of the Service Period @else Completion of the whole of the <i>{{str_contains($contractType,'ECS')?'sub':''}}contract works</i> @endif or earlier termination for which the <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i> maintains insurance for claims made against it arising out of its failure to
        use the skill and care is
        <input type="number" name="x10_service_period_end" class="form-control mt-2" rows="3" placeholder="" value="{{$nec4Contract->x10_service_period_end}}" required>
        @error('x10_service_period_end')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@endif

@if($contractAppl->sec_opt_X12)
@if(str_contains($contractType,'NEC4'))
<h4 class="card-title mt-4 mb-3">X12: Multiparty collaboration (not used with Option X20)</h4>
@endif
<p class="mt-3">If Option X12 is used</p>
<ul class="mb-4">
    <li class="mb-3">The <i>{{str_contains($contractType,'NEC4') ? 'Promoter':'Client'}}</i> is
        <p class="mb-0 mt-3">Name</p>
        <select class="form-control select-user" name="x12_client_is" required>
            <option value="">select</option>
            @foreach ($employerProfiles as $profile)
            <option value="{{$profile->id}}" @if($profile->id==$contractAppl->x12_client_is) selected @endif data="{{$profile}}">{{$profile->name}}</option>
            @endforeach
        </select>
        @error('x12_client_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="mb-0 mt-3">Address @if(str_contains($contractType,'NEC4')) for communications @endif</p>
        <textarea class="form-control mt-2 address" rows="3" required disabled>{{$contractAppl->x12Client && $contractAppl->x12Client->address}}</textarea>
        @if(str_contains($contractType,'NEC4'))
        <p class="mb-0 mt-3">Address for electronic communications</p>
        <textarea class="form-control mt-2 elec-address" rows="3" required disabled>{{$contractAppl->x12Client && $contractAppl->x12Client->electronic_address}}</textarea>
        @endif
    </li>
    @if(str_contains($contractType,'NEC4'))
    <li class="mb-3">The Schedule of Partners is in
        <textarea name="x12_shedule_is_in" class="form-control mt-2" rows="3" required>{{$nec4Contract->x12_shedule_is_in}}</textarea>
        @error('x12_shedule_is_in')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    <li class="mb-3">The <i>{{str_contains($contractType,'NEC4') ? 'Promoter':'Client'}}'s objective</i> is
        <textarea name="x12_client_objective_is" class="form-control mt-2" rows="3" required>{{$contractAppl->x12_client_objective_is}}</textarea>
        @error('x12_client_objective_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The Partnering Information is in
        <textarea name="x12_partnering_information_in" class="form-control mt-2" rows="3" required>{{$contractAppl->x12_partnering_information_in}}</textarea>
        @error('x12_partnering_information_in')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@if($contractAppl->sec_opt_X13 && ($contractType=='NEC4_TSC' ? !$contractAppl->sec_opt_X20 :true))
<h4 class="card-title mt-4 mb-3">X13: Performance bond @if($contractType=='NEC4_TSC') (not used with Option X20) @endif</h4>
<p class="mt-3">If Option X13 is used</p>
<ul class="mb-4">
    <li class="mb-3">The amount of the performance bond is
        <input class="form-control" type="number" name="x13_performance_bond" value="{{$contractAppl->x13_performance_bond}}" style="width: 100px;" required>
        @error('x13_performance_bond')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@if(!str_contains($contractType,'TSC'))

@if($contractAppl->sec_opt_X14 )
@if(str_contains($contractType,'NEC4'))<h4 class="card-title mt-4 mb-3">X14: Advanced payment to the Subcontractor</h4>@endif
<p class="mt-3">If Option X14 is used</p>
<ul class="mb-4">
    <li class="mb-3">The amount of the advanced payment is
        <input class="form-control" type="number" name="x14_advanced_payment" value="{{$contractAppl->x14_advanced_payment}}" style="width: 100px;" required>
        @error('x14_advanced_payment')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The @if(str_contains($contractType,'NEC4')) period after the {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} Date from which the </h4>@endif <i>{{str_contains($contractType,'ECS')?'Subcontractor':'Contractor'}}</i> repays the instalments in assessments starting not less than
        <div class="input-group">
            <input name="x14_instalments_weeks" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->x14_instalments_weeks}}" required>
            <label class="input-group-text mt-2">weeks after the {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} Date</label>
        </div>
        @error('x14_instalments_weeks')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The instalments are
        <div class="row mt-2">
            <!-- <p class="col-md-6">amount</p>
                        <p class="col-md-6">percentage</p> -->
        </div>
        <input name="x14_instalments_amount_or_percentage" type="number" class="form-control" style="flex: inherit; width: 100px;" value="{{$contractAppl->x14_instalments_amount_or_percentage}}" required>
        <div class="mb-2">(either an amount or a percentage of the payment otherwise due)</div>
        @error('x14_instalments_amount_or_percentage')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <!-- <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <label class="input-group-text">weeks after the Contract Date</label>
                                <input name="x14_instalments_amount" type="number" class="form-control" style="flex: inherit; width: 100px;" value="{{$contractAppl->x14_instalments_amount}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input name="x14_instalments_percent" type="number" class="form-control" style="flex: inherit; width: 100px;" value="{{$contractAppl->x14_instalments_percent}}">
                                <label class="input-group-text">weeks after the Contract Date</label>
                            </div>
                        </div>
                    </div> -->
    </li>
    <li class="mb-3">An advanced payment bond
        <div class="row pt-2">
            <input type="checkbox" name="x14_bond" class="customized" {{$contractAppl->x14_bond ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;"> <b><u><span>is</span></u></b> required</label> @if(str_contains($contractType,'NEC4')) (Delete as applicable) @endif
        </div>
        @error('x14_bond')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@if($contractType=="NEC4_ECS" && $contractAppl->sec_opt_X15)
<h4 class="card-title mt-4 mb-3">X15: The Subcontractor’s design</h4>
<p class="mt-3">If Option X15 is used</p>
<ul class="mb-4">
    <li class="mb-3">The <i>period for retention</i> following Completion of the whole of the <i>subcontract works</i> or earlier termination is
        <div class="input-group">
            <input name="x15_retention_period" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$nec4Contract->x15_retention_period}}" required>
        </div>
        @error('x15_retention_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The minimum amount of insurance cover for claims made against the <i>Subcontractor</i> arising
        out of its failure to use the skill and care normally used by professionals designing works similar to the <i>subcontractor works</i> is, in respect of each claim
        <div class="input-group">
            <input name="x15_min_insurance_amount" type="number" min=0 step=0.1 class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$nec4Contract->x15_min_insurance_amount}}" required>
        </div>
        @error('x15_min_insurance_amount')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The period following Completion of the whole of the <i>subcontract works</i> or earlier
        termination for which the <i>Subcontractor</i> maintains insurance for claims made against it arising out of its failure to use the skill and care is
        <div class="input-group">
            <input name="x15_completion_or_termination_period" type="number" min=0 step=0.1 class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$nec4Contract->x15_completion_or_termination_period}}" required>
        </div>
        @error('x15_completion_or_termination_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@if($contractAppl->sec_opt_X16 )
@if(str_contains($contractType,'NEC4'))<h4 class="card-title mt-4 mb-3">X16: Retention</h4>@endif
<p class="mt-3">If Option X16 is used</p>
<ul class="mb-4">
    <li class="mb-3">The <i>retention free amount</i> is
        <div class="input-group">
            <input name="x16_retention_free_amount" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->x16_retention_free_amount}}" required>
        </div>
        @error('x16_retention_free_amount')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>retention percentage</i> is
        <div class="input-group">
            <input name="x16_retention_percent" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->x16_retention_percent}}" required>
            <label class="input-group-text mt-2">%</label>
        </div>
        @error('x16_retention_percent')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@if($contractType=="NEC4_ECS")
<p class="mt-3">Retention bond</p>
<ul class="mb-4">
    <li class="mb-3">
        The <i>Subcontractor</i>
        <!-- <b><u>may / may not</u></b> -->
        <div class="row pt-2">
            <input type="checkbox" name="x16_retention_bond" class="customized" {{$nec4Contract->x16_retention_bond == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">
                <b><u> may</u></b> give the <i>Contractor</i> a retention bond. (Delete as applicable)
            </label>
        </div>
        @error('x16_retention_bond')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
@endif

@endif

@if($contractAppl->sec_opt_X17 )
@if(str_contains($contractType,'NEC4'))<h4 class="card-title mt-4 mb-3">X17: Low performance damages</h4>@endif
<p class="mt-3">If Option X17 is used</p>
<ul class="mb-4">
    @if(str_contains($contractType,'TSC'))
    <li class="mb-3">The <i>service level table</i> is
        <div class="input-group mt-2">
            <input name="x17_slt" type="text" value="{{$contractAppl->x17_slt}}" class="form-control" required>
        </div>
        @error('x17_slt')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @else
    <li class="mb-3">The amounts for low performace damages are
        <div class="row mt-2 col-md-11">
            <p class="col-md-1"></p>
            <p class="col-md-5">amount</p>
            <p class="col-md-6">performance level</p>
        </div>
        <div id="low-perform-damages">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_add_low_perform_damage" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
        </div>
    </li>
    @endif
</ul>
@endif

@if($contractAppl->sec_opt_X18 )
@if(str_contains($contractType,'NEC4'))<h4 class="card-title mt-4 mb-3">X18: Limitation of liability</h4>@endif
<p class="mt-3">If Option X18 is used</p>
<ul class="mb-4">
    <li class="mb-3">The <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i>'s liability to the <i>{{str_contains($contractType,'ECS') ? 'Contractor':(str_contains($contractType,'NEC4') ? 'Client' : 'Employer')}}</i> for indirect or consequential loss is limited to
        <textarea name="x18_indirect_loss" class="form-control mt-2" rows="3" required>{{$contractAppl->x18_indirect_loss}}</textarea>
        @error('x18_indirect_loss')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">For any one event, the <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i>'s liability to the <i>{{str_contains($contractType,'ECS') ? 'Contractor':(str_contains($contractType,'NEC4') ? 'Client' : 'Employer')}}</i> for loss of or damage to the <i>{{str_contains($contractType,'NEC4') ? 'Client' : 'Employer'}} {{str_contains($contractType,'ECS') ? "'s or Contractor" :'' }}</i>'s property is limited to
        <textarea name="x18_loss_damage1" class="form-control mt-2" rows="3" required>{{$contractAppl->x18_loss_damage1}}</textarea>
        @error('x18_loss_damage1')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i>'s liability for Defects due to his design {{str_contains($contractType,'TSC') ? 'of an item of Equipment' : 'which are not listed on the Defects Certificate'}} is limited to
        <textarea name="x18_loss_damage2" class="form-control mt-2" rows="3" required>{{$contractAppl->x18_loss_damage2}}</textarea>
        @error('x18_loss_damage2')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i>'s total liability to the <i>{{str_contains($contractType,'ECS') ? 'Contractor':(str_contains($contractType,'NEC4') ? 'Client' : 'Employer')}}</i> for all matters arising under or in connection with this contract, other than excluded matters, is limited to
        <textarea name="x18_loss_damage3" class="form-control mt-2" rows="3" required>{{$contractAppl->x18_loss_damage3}}</textarea>
        @error('x18_loss_damage3')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>end of liability</i> date is
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="x17_end_liability_number" value="{{$contractAppl->x17_end_liability_number}}" style="width: 100px;" required>
            </div>
            <label class="input-group-text">years after the @if(str_contains($contractType,'TSC')) end of the <i>service period</i> @else Completion of the whole of the&nbsp;<i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i> @endif.</label>
        </div>
        @error('x17_end_liability_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@if(str_contains($contractType,'TSC') && $contractAppl->sec_opt_X19 )
@if(str_contains($contractType,'NEC4'))<h4 class="card-title mt-4 mb-3">X19: Termination by either Party (not used with Option X11)</h4>@endif
<p class="mt-3">If Option X19 is used</p>
<ul class="mb-4">
    @if(str_contains($contractType,'NEC4'))
    <li class="mb-3">The <i>minimum period of service</i> is
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="x19_min_service_period" value="{{$nec4Contract->x19_min_service_period}}" style="width: 100px;" required>
            </div>
            <label class="input-group-text">years after the <i>&nbsp;starting date</i>.</label>
        </div>
        @error('x19_min_service_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>notice period</i> is
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="x19_notice_period" value="{{$nec4Contract->x19_notice_period}}" style="width: 100px;" required>
            </div>
        </div>
        @error('x19_notice_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @else
    <li class="mb-3">The <i>Contractor</i> submits a Task Order programme to the <i>Service Manager</i> within
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="x19_end_task_order_programme_days_number" value="{{$contractAppl->x19_end_task_order_programme_days_number}}" style="width: 100px;" required>
            </div>
            <label class="input-group-text">days of receiving the Task Order.</label>
        </div>
        @error('x19_end_task_order_programme_days_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
</ul>
@endif


@if($contractAppl->sec_opt_X20 )
@if(str_contains($contractType,'NEC4'))<h4 class="card-title mt-4 mb-3">X20: Key Performance Indicators (not used with Option X12)</h4>@endif
<p class="mt-3">If Option X20 is used (but not if Option X12 is also used)</p>
<ul class="mb-4">
    <li class="mb-3">The <i>incentive schedule</i> for Key Performance Indicators is in
        <textarea name="x20_incentive_schedule" class="form-control mt-2" rows="3" required>{{$contractAppl->x20_incentive_schedule}}</textarea>
        @error('x20_incentive_schedule')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">A report of performance against each Key Performance Indicator is provided at intervals of
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="x20_kpi_number" value="{{$contractAppl->x20_kpi_number}}" style="width: 100px;" required>
            </div>
            <label class="input-group-text">months.</label>
        </div>
        @error('x20_kpi_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif


@if($contractType=="NEC4_TSC")

@if($contractAppl->sec_opt_X23 )
<h4 class="card-title mt-4 mb-3">X23: Extending the Service Period</h4>
<p class="mt-3">If Option X23 is used <small>(but not if Option X12 is also used)</small></p>
<ul class="mb-4">
    <li class="mb-3">The <i>maximum period</i> is
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" name="x23_max_period" value="{{$nec4Contract->x23_max_period}}" style="width: 100px;" required>
            </div>
            <label class="input-group-text">years after the <i>starting date</i>.</label>
        </div>
        @error('x23_max_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>periods for extension</i> are
        <div class="row mt-2 col-md-11">
            <div class="col-md-2">
                <p class="mb-0">order</p>
            </div>
            <div class="col-md-5 px-2" style="padding: 0;">
                <p class="mb-0"><i>period for extension</i> (months)</p>
            </div>
            <div class="col-md-5 px-2" style="padding-left: 0;">
                <p class="mb-0"><i>notice date</i></p>
            </div>
            <div id="extension-periods">

            </div>
        </div>
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_add_extension_period" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </li>
</ul>
<p class="mt-3">If there are <i>criteria for extension</i></p>
<ul class="mb-4">
    <li class="mb-3">The <i>criteria for extension </i> are
        <div id="extension-criteria">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_add_extension_criteria" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
        </div>
    </li>
</ul>
@endif

@if($contractAppl->sec_opt_X24 )

<h4 class="card-title mt-4 mb-3">X24: <i>accounting periods</i></h4>
@if(!str_starts_with($contractAppl->main_opt,'Option C:'))
<p class="mt-3">If Option X24 is used and Option C is not used</p>
<ul class="mb-4">
    <li class="mb-3">The <i>accounting periods</i> are
        <div id="accounting-periods">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_add_accounting_period" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
        </div>

    </li>
</ul>
@endif

@if(str_starts_with($contractAppl->main_opt,'Option C:'))
<p class="mt-3">If Option X24 is used with Option C</p>
<ul class="mb-4">
    <li class="mb-3">The <i>accounting periods</i> are the dates stated in the Contract Data of
        assessment of the
        <p><i>Contractor’s</i> share</p>
    </li>
</ul>
@endif

@endif

@endif


@if(!str_contains($contractType,'ECS'))

@if($contractAppl->sec_opt_yUK1 )
@if(str_contains($contractType,'NEC4'))
<h4 class="card-title mt-4 mb-3">Y(UK)1: Project Bank Account</h4>
<p class="mt-3">Charges made and interest paid by the <i>project bank</i></p>
@else
<p class="mt-3">If Option Y(UK)1 is used and the <i>Employer</i> is to pay any charges made and is paid any interest paid by the <i>project bank</i>.</p>
@endif
<ul class="mb-4">
    <li class="mb-3">The <i>@if(str_contains($contractType,'NEC4')) Contractor <b><u>is/is not</u></b> @else Employer is @endif</i> to pay any charges made and {{str_contains($contractType,'NEC4') ? 'to be':'is'}} paid any interest paid by the <i>project bank</i>.@if(str_contains($contractType,'NEC4')) (Delete as applicable) @endif
        <textarea name="yuk1_pay_any_charge" class="form-control mt-2" rows="3" required>{{$contractAppl->yuk1_pay_any_charge}}</textarea>
        @error('yuk1_pay_any_charge')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@endif

@if(str_contains($contractType,'NEC4'))

@if($contractAppl->sec_opt_yUK2)
<h4 class="card-title mt-4 mb-3">Y(UK)2: The Housing Grants, Construction and Regeneration Act 1996</h4>
@if(str_contains($contractType,'TSC'))
<p class="mt-3">If Y(UK)2 is used and the date on which a payment is due is not
    fourteen weeks after the end of the <i>accounting period</i> or Service
    Period</p>
<ul class="mb-4">
    <li class="mb-3">The period is
        <div class="input-group mt-2">
            <div class="input-group-prepend col-md-2">
                <input name="yuk2_accounting_period" type="number" class="form-control" style="border-bottom-right-radius: 0" value="{{$nec4Contract->yuk2_accounting_period}}" required>
            </div>
            <label class="input-group-text">weeks</label>
        </div>
        @error('yuk2_accounting_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
<p class="mt-3">If Y(UK)2 is used and the final date for payment is not fourteen
    days after the date on which payment becomes due</p>
<ul class="mb-4">
    <li class="mb-3">The period for payment is
        <div class="input-group mt-2">
            <div class="input-group-prepend col-md-2">
                <input name="yuk2_due_payment_period" type="number" class="form-control" style="border-bottom-right-radius: 0" value="{{$nec4Contract->yuk2_due_payment_period}}" required>
            </div>
            <label class="input-group-text">days after the date on which pay becomes due</label>
        </div>
        @error('yuk2_due_payment_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@endif


@if($contractAppl->sec_opt_yUK3 )

@if(str_contains($contractType,'NEC4'))<h4 class="card-title mt-4 mb-3"> Y(UK)3: The Contracts (Rights of Third Parties) Act 1999</h4>@endif
<p class="mt-3">If Option Y(UK)3 is used</p>
<ul class="mb-4">
    <!-- <li class="mb-3"> -->
    <div class="row col-md-11">
        <div class="col-md-1">
        </div>
        <div class="col-md-7">
            <p>term</p>
        </div>
        <div class="col-md-4">
            <p>@if(str_contains($contractType,'NEC4')) <i>beneficiary</i> @else person or organisation @endif</p>
        </div>
    </div>
    <div id="benificiary-terms">

    </div>
    <div class="my-2 d-flex justify-content-end col-md-11">
        <button type="button" id="btn_add_benificiary_term" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
    <!-- </li> -->
</ul>
@if($contractAppl->sec_opt_yUK3 )

@if(str_contains($contractType,'NEC4'))
<p class="mt-3">If Y(UK)3 is used with Y(UK)1 the following entry is added to the table for Y(UK)3</p>
@else
<p class="mt-3">If Options Y(UK)1 and Y(UK)3 are both used</p>
@endif
<ul class="mb-4">
    <li class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <p>term</p>
                <p>
                    The provisions of Option Y(UK)1
                </p>
            </div>
            <div class="col-md-6">
                <p>@if(str_contains($contractType,'NEC4')) <i>beneficiary</i> @else person or organisation @endif</p>
                <p>
                    Named Suppliers
                </p>
            </div>
        </div>
    </li>
</ul>

@endif

@endif

@if($contractAppl->sec_opt_Z1 )
<div id="if_z1_used">
    <p class="mt-3">If Option Z is used</p>
    <ul class="mb-4">
        <li class="mb-3">
            The <i>additional conditions of contract</i> are
        </li>
        <textarea name="add_cond_z1" class="form-control mt-2" rows="3" required>{{$contractAppl->add_cond_z1}}</textarea>
        @error('add_cond_z1')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </ul>
</div>
@endif