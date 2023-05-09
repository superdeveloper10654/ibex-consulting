<h4 class="card-title mt-4 mb-3">Liabilities and insurance</h4>
@if (!str_contains($contractType,'NEC4'))
@include('tenant.contracts.steps.nec3-optional-statements')
@endif

<p class="mt-3">If there are additional @if(str_contains($contractType,'NEC4')) <i>Client's</i> liabilities @else <i>Employer's @if(str_contains($contractType,'ECS')) or Contractor's @endif </i> Risks @endif</p>
<ul class="mb-4">
    <li class="mb-3">These are the additional @if(str_contains($contractType,'NEC4')) <i>Client's</i> liabilities @else <i>Employer's</i> Risks @endif
        <div id="additional-risks">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_employer_risk_add" class="btn btn-sm btn-primary my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add </button>
        </div>
    </li>
</ul>
@if (str_contains($contractType,'ECS'))
@if(str_contains($contractType,'NEC4'))
<p class="mt-3">If there are additional <i>Contractor's</i> {{str_contains($contractType,'NEC4') ? 'liabilities' : 'Risks'}}</p>
@endif
<ul class="mb-4">
    <li class="mb-3">These are the additional <i>Contractor's</i> {{str_contains($contractType,'NEC4') ? 'liabilities' : 'Risks'}}
        <div id="additional-contractor-risks">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-11">
            <button type="button" id="btn_contractor_risk_add" class="btn btn-sm btn-primary my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add </button>
        </div>
    </li>
</ul>
@endif
@if (str_contains($contractType,'NEC4'))
<ul class="mb-4">
    <li class="mb-3">The minimum amount of cover for insurance against loss of or damage to property (except @if(str_contains($contractType,'ECS')) the <i>subcontract</i> works, @endif
        Plant and Materials and Equipment) and liability for bodily injury to or death of a person (not an employee of the <i>{{str_contains($contractType,'ECS')?'Subcontractor':'Contractor'}}</i>)
        arising from or in connection with the <i>{{str_contains($contractType,'ECS')?'Subcontractor':'Contractor'}}</i> Providing the {{str_contains($contractType,'ECS')?'Subcontract Works':'Service'}} for anyone event is
        <input type="text" name="insurance_text_1" class="form-control mt-2" required value="{{$contractAppl->insurance_text_1}}">
        @error('insurance_text_1')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The minimum amount of cover for insurance against death and of or bodily injury to employees of the
        <i>{{str_contains($contractType,'ECS')?'Subcontractor':'Contractor'}}</i> arising out of and in the course of their employment in connection with the {{str_contains($contractType,'ECS')?'subcontract':'contract'}} for any one event is
        <input type="text" name="insurance_min_text_2" class="form-control mt-2" required value="{{$contractAppl->insurance_min_text_2}}">
        @error('insurance_min_text_2')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
<p class="mt-3">If the <i>{{str_contains($contractType,'NEC4') ? 'Client' : 'Employer'}}</i> @if (str_contains($contractType,'ECS')) or <i>Contractor</i> @endif is to provide Plant and Materials</p>
<ul class="mb-4">
    <li class="mb-3">The insurance against loss of or damage to @if(str_contains($contractType,'ECS')) <i>subcontract</i> @endif @if(!str_contains($contractType,'TSC')) works, @endif Plant and Materials is to include cover for Plant and Materials provided by the <i>{{str_contains($contractType,'NEC4') ? 'Client' : 'Employer'}}</i> @if(str_contains($contractType,'ECS')) or <i>Contractor</i> @endif for an amount of
        <input name="employer_insurance_plant_materials" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->employer_insurance_plant_materials}}" required>
        @error('employer_insurance_plant_materials')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
<p class="mt-3">If the <i>{{str_contains($contractType,'NEC4') ? 'Client' : 'Employer'}}</i> @if (str_contains($contractType,'ECS')) or <i>Contractor</i> @endif is to provide any of the insurances stated in the Insurance Table</p>
<ul class="mb-4">
    <li class="mb-3">The <i>{{str_contains($contractType,'NEC4') ? 'Client' : 'Employer'}}</i> @if (str_contains($contractType,'ECS')) or <i>Contractor</i> @endif provides these insurances from the Insurance Table
        <div id="new-insurance">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-12">
            <button type="button" id="btn_add_insurance" class="btn btn-sm btn-primary my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add </button>
        </div>
    </li>
</ul>
<p class="mt-3">If additional insurances are to be provided</p>
<ul class="mb-4">
    <li class="mb-3">The <i>{{str_contains($contractType,'NEC4') ? 'Client' : 'Employer'}}</i>@if (str_contains($contractType,'ECS')) or <i>Contractor</i> @endif provides these additional insurances
        <div id="new-emp-add-insurance">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-12">
            <button type="button" id="btn_add_insurance1" class="btn btn-sm btn-primary my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add&nbsp;</button>
        </div>
    </li>
</ul>
<ul class="mb-4">
    <li class="mb-3">The <i>{{str_contains($contractType,'ECS') ? 'Subcontractor':'Contractor'}}</i> provides these additional insurances
        <div id="new-contr-add-insurance">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-12">
            <button type="button" id="btn_add_insurance2" class="btn btn-sm btn-primary my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add&nbsp;</button>
        </div>
    </li>
</ul>

@if(str_contains($contractType,'NEC4'))
<hr>
<h4 class="card-title mt-4 mb-3">Resolving and avoiding disputes</h4>
<p class="mt-3">If <i>tribunal</i> is arbitration</p>
<ul class="mb-4">
    <li class="mb-3">The <i>tribunal</i> is
        <input type="text" name="tribunal_is" class="form-control mt-2" value="{{$contractAppl->tribunal_is}}" required>
        @error('tribunal_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
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
    <li class="mb-3">The person or organisation who will choose an arbitrator if the Parties cannot agree a choice or if the <i>arbitration proceedure</i> does not state who selects an arbitrator is
        <input type="text" name="arbitration_chooser_is" class="form-control mt-2" value="{{$contractAppl->arbitration_chooser_is}}" required>
        @error('arbitration_chooser_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>Senior Representatives</i> of the <i>{{str_contains($contractType,'ECS')?'Contractor':'Client'}}</i> are
        @error('senior_representatives')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror

        <div id="SR">

        </div>
        <div class="my-2 d-flex justify-content-end col-md-12">
            <button type="button" id="btn_add_SR" class="btn btn-sm btn-primary float-right my-3"><i class="mdi mdi-plus me-1"></i>&nbsp;Add&nbsp;</button>
        </div>

    </li>
    @if(str_contains($contractType,'ECS'))
    <li class="mb-3">The <i>Adjudicator</i> in this subcontract is
        <p class="mb-0 mt-3">Name</p>
        <select class="form-control select-user" name="sub_adj_id" required>
            <option value="">select</option>
            @foreach ($adjudicatorProfiles as $profile)
            <option value="{{$profile->id}}" @if($profile->id==$contractAppl->sub_adj_id) selected @endif data="{{$profile}}">{{$profile->name}}</option>
            @endforeach
        </select>
        @error('sub_adj_id')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="mb-0 mt-3">Address</p>
        <textarea class="form-control mt-2 address" rows="3" required disabled>{{$contractAppl->adj_address_is}}</textarea>
        <p class="mb-0 mt-3">Address for electronic communications</p>
        <textarea class="form-control mt-2 elec-address" rows="3" required disabled>{{$contractAppl->sup_electronic_address_is}}</textarea>
    </li>
    @endif
    <li class="mb-3">The <i>@if(str_contains($contractType,'ECS')) Main Contract @endif Adjudicator</i> is
        <p class="mb-0 mt-3">Name</p>
        <select class="form-control select-user" name="adj_id" required>
            <option value="">select</option>
            @foreach ($adjudicatorProfiles as $profile)
            <option value="{{$profile->id}}" @if($profile->id==$contractAppl->adj_id) selected @endif data="{{$profile}}">{{$profile->name}}</option>
            @endforeach
        </select>
        @error('adj_id')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="mb-0 mt-3">Address</p>
        <textarea class="form-control mt-2 address" rows="3" required disabled>{{$contractAppl->main_adj_address_is}}</textarea>
        <p class="mb-0 mt-3">Address for electronic communications</p>
        <textarea class="form-control mt-2 elec-address" rows="3" required disabled>{{$contractAppl->sup_electronic_address_is}}</textarea>
    </li>
    @if(str_contains($contractType,'ECS'))
    <li class="mb-3">The <i>Adjudicator nominating body</i> is
        <input type="text" name="adjudicator_body_is" class="form-control mt-2" value="{{$contractAppl->adjudicator_body_is}}" required>
        @error('adjudicator_body_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
</ul>
@else
@if (str_contains($contractType,'TSC'))
@if($contractAppl->main_opt == 'Option A: Priced contract with Activity Schedule')
<div id="if_x1_used">
    <p class="mt-3">If Option A is used</p>
    <ul class="mb-4">
        <li class="mb-3">The <i>Contractor</i> prepares forecasts of the final total of the Prices for the
            whole of the <i>service</i> at intervals no longer than
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
</div>
@endif
@else
@if(str_starts_with($contractAppl->main_opt,'Option D') || str_starts_with($contractAppl->main_opt,'Option D'))
<p class="mt-3">If Option B or D is used</p>
<ul class="mb-4" style="margin-left: -1rem !important;">
    <li class="mb-3">
        The <i>method of measurement</i> is
        <textarea name="method_of_measurement_is" class="form-control mt-2" rows="3" required>{{$contractAppl->method_of_measurement_is}}</textarea>
        @error('method_of_measurement_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="mt-3">amended as follows</p>
        <textarea name="method_of_measurement_amendments" class="form-control mt-2" rows="3" required>{{$contractAppl->method_of_measurement_amendments}}</textarea>
        @error('method_of_measurement_amendments')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
</ul>
@endif
@endif
@endif