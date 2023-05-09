<h4 class="card-title mt-4 mb-3">Optional statements</h4>
<h6 class="mt-3">If <i>tribunal</i> is arbitration</h6>
<ul class="mb-4">
    <li class="mb-3">The <i>arbitration proceedure</i> is
        <input type="text" name="arbitration_proceedure_is" class="form-control mt-2" value="{{$contractAppl->arbitration_proceedure_is}}" required>
        @error('arbitration_proceedure_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The place where arbitration is to be held is
        <input type="text" name="arbitration_place_is" class="form-control mt-2" value="{{$contractAppl->arbitration_place_is}}" required>
        @error('arbitration_place_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li>The person or organisation who will choose an arbitrator
    </li>
    <li class="ms-3">if the Parties cannot agree a choice or
    </li>
    <li class="ms-3">if the <i>arbitration proceedure</i> does not state who selects an arbitrator is
        <input type="text" name="arbitration_chooser_is" class="form-control mt-2" value="{{$contractAppl->arbitration_chooser_is}}" required>
        @error('arbitration_chooser_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@if(!str_contains($contractType,'TSC'))
<h6 class="mt-3">If the <i>{{str_contains($contractType,'ECS') ? 'Contractor':'Employer'}}</i> has decided the <i>@if(str_contains($contractType,'ECS')) subcontract @endif completion date</i> for the whole of the <i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i></h6>
<ul class="mb-4">
    <li class="mb-3">The <i>@if(str_contains($contractType,'ECS')) subcontract @endif completion date</i> for the whole of the <i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i> is
        <input class="form-control mt-2" type="date" id="completion_date" name="completion_date" style="width: 220px;" value="{{$contractAppl->completion_date}}" required>
        @error('completion_date')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
<h6 class="mt-3">If the <i>{{str_contains($contractType,'ECS') ? 'Contractor':'Employer'}}</i> is not willing to take over the <i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i> before the @if(str_contains($contractType,'ECS')) Subcontract @endif Completion Date</h6>
<ul class="mb-4">
    <li class="mb-3">The <i>{{str_contains($contractType,'ECS') ? 'Contractor':'Employer'}}</i> is not willing to take over the <i>@if(str_contains($contractType,'ECS')) subcontract @endif works</i> before the @if(str_contains($contractType,'ECS')) Subcontract @endif Completion Date.
    </li>
</ul>
@endif
<h6 class="mt-3">If no {{str_contains($contractType,'TSC') ? 'plan':'programme'}} is identified in part two of the {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} Data</h6>
<ul class="mb-4">
    <li class="mb-3">The <i>Contractor</i> is to submit a first {{str_contains($contractType,'TSC') ? 'plan':'programme'}} for acceptance within
        <div class="input-group">
            <input name="first_programme_within" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->first_programme_within}}" required>
            <label class="input-group-text mt-2">weeks of the {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} Date.</label>
        </div>
        @error('first_programme_within')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@if(!str_contains($contractType,'TSC'))
<h6 class="mt-3">If the <i>{{str_contains($contractType,'ECS') ? 'Contractor' : 'Employer'}}</i> has identified work which is to meet a stated <i>condition</i> by a <i>key date</i></h6>
<ul class="mb-4">
    <li class="mb-3">The <i>key dates</i> and <i>conditions</i> to be met are
        <div class="row col-md-11 mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-8">
                <h6><i>condition</i> to be met</h6>
            </div>
            <div class="col-md-3">
                <h6><i>key date</i></h6>
            </div>
        </div>
        <div id="conditions">
        </div>
    </li>
    <button type="button" id="btn_add_condition" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add </button>
</ul>
@endif
<h6 class="mt-3">If the period in which payments are made is not {{str_contains($contractType,'ECS') ? 'four' : 'three'}} weeks and Y(UK)2 is not used</h6>
<ul class="mb-4">
    <li class="mb-3">The period within which payments are made is
        <div class="input-group">
            <input name="payment_period_not_yuk2_number" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->payment_period_not_yuk2_number}}" required>
            <div class="input-group-append">
                <input name="payment_period_not_yuk2_text" type="text" class="form-control mt-2" style="flex: inherit; width: 100px;" value="weeks." value="{{$contractAppl->payment_period_not_yuk2_text}}" required>
            </div>
        </div>
        @error('payment_period_not_yuk2_number')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        @error('payment_period_not_yuk2_text')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@if(!str_contains($contractType,'TSC'))
<h6 class="mt-3">If Y(UK)2 is used and the final date for payment is not 14 days after the date when payment is due</h6>
<ul class="mb-4">
    <li class="mb-3">The period for payment is
        <div class="input-group">
            <input name="payment_period_yuk2_number" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->payment_period_yuk2_number}}" required>
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
@else
<h6 class="mt-3">If Y(NZ)1 is used and the final date for payment is not 14 days after the date when payment is due</h6>
<ul class="mb-4">
    <li class="mb-3">The period for payment is
        <div class="input-group">
            <input name="ynz1_payment_period" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->ynz1_payment_period}}" required>
            <label class="input-group-text mt-2">days.</label>
        </div>
        @error('ynz1_payment_period')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif