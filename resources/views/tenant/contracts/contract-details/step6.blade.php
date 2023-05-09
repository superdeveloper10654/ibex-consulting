@if($contractType!='TSC')<h4 class="card-title mt-4 mb-3">{{str_contains($contractType,'NEC4') ? ' Quality management' : 'Testing and Defects'}}</h4>@endif
<ul class="mb-4">
    @if(str_contains($contractType,'NEC4'))
    <li class="mb-3">The period after the {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} Date within which the
        <i>{{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}}</i> is to submit a quality policy statement and quality plan is
        <div class="input-group">
            <input name="quality_policy_plan_period" type="number" min=0 class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$nec4Contract->quality_policy_plan_period}}" required>
            <div class="input-group-append">
                <span class="input-group-text mt-2">weeks
                </span>
            </div>
        </div>
        @error('quality_policy_plan_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    @if(!str_contains($contractType,'TSC'))
    <li class="mb-3">@if(str_contains($contractType,'NEC4')) The period between Completion of the whole of the <i>subcontract works</i> and the @else The @endif <i>defects date</i> is
        <div class="input-group">
            <input name="defects_date" type="number" min=0 class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->defects_date}}" required>
            <div class="input-group-append">
                <span class="input-group-text mt-2">weeks @if(!str_contains($contractType,'NEC4')) after Completion of the whole of the&nbsp;<i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i>@endif</span>
            </div>
        </div>
        @error('defects_date')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>defects correction period</i> is
        <div class="input-group">
            <input name="defect_correction_period" type="number" min=0 class="form-control mt-2" style="flex: inherit; width: 100px;" required value="{{$contractAppl->defect_correction_period}}">
            <div class="input-group-append">
                <span class="input-group-text mt-2">weeks</span>
            </div>
        </div>
        @error('defect_correction_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <div class="m-2">
        <div class="mt-2 mb-4" id="except-periods">
            except that
        </div>
      <div class="mt-4 d-flex justify-content-end col">
            <button type="button" id="btn_add" class="btn btn-sm btn-light"><i class="mdi mdi-plus me-1"></i><small>Add Row</small></button>
        </div>
    </div>
    @endif
</ul>

<h4 class="card-title mt-4 mb-3">Payment</h4>
<ul class="mb-4">
    <li class="mb-3">The <i>currency of this {{str_contains($contractType,'ECS') ? 'sub':''}}contract </i> is the
        <input type="text" name="currency_is" class="form-control mt-2" placeholder="Pound Sterling" required value="{{$contractAppl->currency_is}}">
        @error('currency_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>assessment interval</i> is
        <div class="input-group">
            <input name="assessment_interval" type="number" min=0 class="form-control mt-2" style="flex: inherit; width: 100px;" required value="{{$contractAppl->assessment_interval}}">
            <div class="input-group-append">
                <span class="input-group-text mt-2">weeks</span>
            </div>
        </div>
        @error('assessment_interval')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>interest rate</i> is
        <div class="input-group">
            <input name="interest_rate_percentage" type="number" min="2" step="0.01" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->interest_rate_percentage}}" required>
            <div class="input-group-append">
                <span class="input-group-text mt-2">% per annum (not less than 2) above the</span>
            </div>
            <div class="input-group-append col">
                    <input name="interest_rate_text_1" type="text" class="form-control mt-2" style="border-radius: 0;" placeholder="base" value="{{$contractAppl->interest_rate_text_1}}" required>
            </div>
            <div class="input-group-append">
                <span class="input-group-text mt-2">rate of the </span>
            </div>
            <div class="input-group-append col">
                    <input name="interest_rate_text_2" type="text" class="form-control mt-2" style="border-radius: 0;" placeholder="Bank of England" value="{{$contractAppl->interest_rate_text_2}}" required>
            </div>
            <div class="input-group-append">
                <span class="input-group-text mt-2">bank</span>
            </div>
        </div>
        @error('interest_rate_percentage')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        @error('interest_rate_text_1')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        @error('interest_rate_text_2')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@if (str_contains($contractType,'NEC4'))
<h6 class="mt-3">If the period in which payments are made is not {{str_contains($contractType,'ECS') ? 'four' : 'three'}} weeks and Y(UK)2 is not used</h6>
<ul class="mb-4">
    <li class="mb-3">The period within which payments are made is
        <div class="input-group">
            <input name="payment_period_yuk2_number" type="number" min=0 class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->payment_period_yuk2_number}}" required>
            <div class="input-group-append">
                <input name="payment_period_yuk2_text" type="text" class="form-control mt-2" style="flex: inherit; width: 100px;" value="weeks." value="{{$contractAppl->payment_period_yuk2_text}}" required>
            </div>
        </div>
        @error('payment_period_yuk2_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        @error('payment_period_yuk2_text')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>

</ul>

@if ($contractType=='NEC4_TSC')
<h6 class="mt-3">If the period for certifying a final assessment is not thirteen weeks</h6>
<ul class="mb-4">
    <li class="mb-3">The period for certifying a final assessment is
        <div class="input-group">
            <input name="final_assessment_period" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$nec4Contract->final_assessment_period}}" required>
            <label class="input-group-text mt-2">weeks</label>
        </div>
        @error('final_assessment_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif


@if(
str_starts_with($contractAppl->main_opt , 'Option C:')
||
(!str_contains($contractType,'TSC') && str_starts_with($contractAppl->main_opt , 'Option D:') )
)
<h6 class="mt-3">If Option C @if(!str_contains($contractType,'TSC')) or D @endif is used</h6>
<ul class="mb-4">
    <li class="mb-3">The <i> {{str_contains($contractType,'ECS') ? 'Subontractor':'Contractor'}} ’s share percentages </i> and the <i>share ranges</i> are
        <div class="row mt-2 align-items-top">
            <div class="col-lg-6 col-8">share range</div>
            <div class="col">{{str_contains($contractType,'ECS') ? 'Subontractor':'Contractor'}}’s share percentage</div>
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
</ul>
@endif
@if(
    str_starts_with($contractAppl->main_opt , 'Option C:')||str_starts_with($contractAppl->main_opt , 'Option E:')
||
(!str_contains($contractType,'TSC') &&
(
str_starts_with($contractAppl->main_opt , 'Option D:')
||
(str_contains($contractType,'ECC') && str_starts_with($contractAppl->main_opt , 'Option F:'))
)
)
)
<h6 class="mt-3">
    If Option C
    @if(str_contains($contractType,'TSC'))
    or E
    @elseif(str_contains($contractType,'ECC'))
    , D , E or F
    @else
    , D or E
    @endif
    is used
</h6>
@if(str_contains($contractType,'TSC'))
<ul class="mb-4">
    <li class="mb-3">The <i>Contractor’s</i> share is assessed on (dates)
        <input type="text" name="share_assesed_on" class="form-control mt-2 date" placeholder="Pick the multiple dates" value="{{$contractAppl->share_assesed_on}}">
        @error('share_assesed_on')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
<ul class="mb-4">
    <li class="mb-3">
        The <i>exchange rates</i> are those published in
        <div class="input-group mt-2">
            <input name="exchange_rates_text" type="text" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->exchange_rates_text}}">
            <label class="input-group-text mt-2">on</label>
            <input type="date" class="form-control date mt-2" name="exchange_rates_date" style="flex: inherit; width: 150px;" value="{{$contractAppl->exchange_rates_date}}">
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