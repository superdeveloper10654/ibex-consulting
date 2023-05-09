@if (str_contains($contractType,'NEC4'))

<h4 class="card-title mt-2 mb-4">The <i>{{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}}’s</i> main responsibilities</h4>

@if (!str_contains($contractType,'TSC'))
<h6 class="mt-3">If the <i>Contractor</i> has identified work which is set to meet a stated condition by a <i>key date</i></h6>
<ul class="mb-4">
    <li class="mb-3">The key <i> dates </i> and <i> conditions </i> to be met are
        <div class="row col-md-11 mt-2">
            <div class="col-md-10 ms-5 px-0">
                <h6><i>condition</i> to be meet</h6>
            </div>
            <div class="col-md-1 px-0">
                <h6><i>key date</i></h6>
            </div>
        </div>
        <div id="conditions">
        </div>
        <div class="mt-4 d-flex justify-content-end col">
            <button type="button" id="btn_add_condition" class="btn btn-sm btn-light"><i class="mdi mdi-plus me-1"></i><small>Add Row</small></button>
        </div>
    </li>
</ul>
@endif

@if(str_starts_with($contractAppl->main_opt , 'Option C:') || str_starts_with($contractAppl->main_opt ,'Option E:')
||
(!str_contains($contractType,'TSC') &&
(
str_starts_with($contractAppl->main_opt , 'Option D:') || (str_contains($contractType,'ECC') && str_starts_with($contractAppl->main_opt , 'Option F:')))
)
)
<div class="print-clear-both"></div>

<h6 class="mt-3">
    If Option C
    @if(str_contains($contractType,'TSC'))
    or E
    @elseif(str_contains($contractType,'ECS'))
    , D or E
    @else
    , D , E or F
    @endif
    is used
</h6>
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
</ul>
@endif

@if (str_contains($contractType,'TSC'))
<ul class="mb-4">
    <li class="mb-3">The period within which the <i>Contractor</i> is to submit a Task Order programme for acceptance is
        <div class="input-group">
            <input class="mt-2 form-control" type="number" step="1" min="1" name="x19_end_task_order_programme_days_number" style="flex: inherit; width: 100px;" value="{{$nec4Contract->end_task_order_programme_period}}" required />
            <label class="input-group-text mt-2">days</label>
        </div>
        @error('x19_end_task_order_programme_days_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif

@endif

<h4 class="card-title mb-3">Time</h4>
<ul class="mb-4">
    <li class="mb-3">The <i>@if(str_contains($contractType,'ECS')) subcontract @endif starting date</i> is
        <input type="date" class="mt-2 form-control" name="starting_date" value="{{$contractAppl->starting_date}}" required />
        @error('starting_date')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @if(str_contains($contractType,'TSC'))
    <li class="mb-3">The <i> service period</i> is
        <input type="date" class="mt-2 form-control" name="service_period_is" value="{{$contractAppl->starting_date}}" required />
        @error('service_period_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @else
    <li class="mb-3" id="access-dates">The <i>@if(str_contains($contractType,'ECS')) subcontract @endif access dates</i> are
        <div class="row col-md-11 mt-2">
            <div class="col-md-10 mx-0">
                <h6 class="mb-0">Part of the Site</h6>
            </div>
            <div class="col-md-1 mx-0">
                <h6>Date</h6>
            </div>
        </div>
    </li>
    <div class="mt-4 d-flex justify-content-end col">
        <button type="button" id="btn_add_access_date" class="btn btn-sm btn-light"><i class="mdi mdi-plus me-1"></i><small>Add Row</small></button>
    </div>
    @endif

    <div class="print-clear-both"></div>

    @if(!str_contains($contractType,'TSC')|| str_contains($contractType,'NEC4'))
    <li>The <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i> submits revised {{str_contains($contractType,'TSC') ? 'plans':'programmes'}} at intervals no longer than
        <div class="input-group">
            <input name="programme_interval_is" type="number" min=0 class="form-control mt-2" style="flex: inherit; width: 100px;" required value="{{$contractAppl->programme_interval_is}}">
            <label class="input-group-text mt-2">weeks</label>
        </div>
        @error('programme_interval_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
</ul>

@if(str_contains($contractType,'NEC4'))
@if(!str_contains($contractType,'TSC'))
<h6 class="mt-3">If the <i>Contractor</i> has decided the <i>@if(str_contains($contractType,'ECS')) subcontract @endif completion date</i> for the whole of the <i>subcontract works</i></h6>
<ul class="mb-4">
    <li class="mb-3">The <i> @if(str_contains($contractType,'ECS')) subcontract @endif completion date</i> for the whole of the <i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i> is
        <input class="form-control mt-2" type="date" id="completion_date" name="completion_date" style="width: 220px;" value="{{$contractAppl->completion_date}}" required>
        @error('completion_date')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
<h6 class="mt-3">Taking over the <i>subcontract</i> works before the @if(str_contains($contractType,'ECS')) Subcontract @endif Completion Date</h6>
<ul class="mb-4">
    <li class="mb-3 toggle-section">
        <div>
            <input type="checkbox" name="is_takeover_completion_date" class="customized is_or_is_not" {{$nec4Contract->is_takeover_completion_date ? 'checked':''}} />
            <div class="py-2" style="margin-left: -15px;">
                The <i>Contractor&nbsp;</i> <b><u><span class="is_or_is_not_value"> {{$nec4Contract->is_takeover_completion_date ? 'is':'is not'}} </span></u></b> willing to take over the <i>subcontract works</i> before the @if(str_contains($contractType,'ECS')) Subcontract @endif Completion Date.
                <input class="form-control mt-2 is_hide {{$nec4Contract->is_takeover_completion_date ? '':'d-none'}}" type="date" id="completion_date" name="takeover_completion_date" style="width: 220px;" value="{{$nec4Contract->takeover_completion_date}}" "{{$nec4Contract->takeover_completion_date ? 'required' : ''}}">
                @error('is_takeover_completion_date')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                @error('takeover_completion_date')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
    </li>
</ul>
@endif
<h6 class="mt-3">If no {{str_contains($contractType,'TSC') ? 'plan' : 'programme'}} is identified in part two of the {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} Data</h6>
<ul class="mb-4">
    <li class="mb-3">The period after the {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} Date within which the <i>{{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}}</i> is to submit a first {{str_contains($contractType,'TSC') ? 'plan' : 'programme'}} for acceptance is
        <div class="input-group">
            <input name="first_programme_within" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->first_programme_within}}" required>
            <label class="input-group-text mt-2">weeks of the Contract Date.</label>
        </div>
        @error('first_programme_within')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif