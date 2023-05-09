<ul class="mb-4">
    @if(str_contains($contractType,'NEC4'))
    <h4 class="card-title mt-4 mb-3">General</h4>
    @endif
    <li class="mb-3">The <i>{{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}}</i> is
        <p class="mb-0 mt-3">Name</p>
        <input type="text" class="form-control mt-2" value="{{$contract->contractor_profile->organisation}}" disabled />
        {{--<select class="form-control select-user" name="employer_or_client_id" required>
            <option value="">select</option>
            @foreach ($contractorProfiles as $profile)
            <option value="{{$profile->id}}" @if($profile->id==$contractAppl->employer_or_client_id) selected @endif data="{{$profile}}">{{$profile->name}}</option>
        @endforeach
        </select>--}}
        <p class="mb-0 mt-3">Address @if(str_contains($contractType,'NEC4')) for communications @endif</p>
        <textarea class="form-control mt-2" rows="3" disabled>{{$contract->contractor_profile->address}}</textarea>
        @if(str_contains($contractType,'NEC4'))
        <p class="mb-0 mt-3">Address for electronic communications</p>
        <textarea class="form-control mt-2" rows="3" disabled>{{$contract->contractor_profile->electronic_address}}</textarea>
        @endif
    </li>

    @if(str_contains($contractType,'NEC4'))
    <li class="mb-3">The <i>fee percentage </i> is
        @else
    <li class="mb-3">The <i>direct fee </i>percentage is
        @endif
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" min=0 step=0.01 name="direct_fee" style="width: 100px;" value="{{$contractData2->direct_fee}}" required>
            </div>
            <label class="input-group-text">%</label>
        </div>
        @error('direct_fee')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @if(!str_contains($contractType,'NEC4'))
    @if($contractType=='ECS')
    <li class="mb-3">The <i>subsubcontracted fee</i> percentage is
        @else
    <li class="mb-3">The <i>subcontracted fee</i> percentage is
        @endif
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <input class="form-control" type="number" step=0.01 name="subcontracted_fee" style="width: 100px;" value="{{$contractData2->subcontracted_fee}}" required>
            </div>
            <label class="input-group-text">%</label>
        </div>
        @error('subcontracted_fee')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    @if(str_contains($contractType,'ECS') || str_contains($contractType,'NEC4_TSC'))
    <li class="mb-3">The <i>@if(str_contains($contractType,'ECS')) subcontract @endif {{str_contains($contractType,'TSC') ? 'service':'working'}} areas</i> are
        <div class="input-group mt-2">
            <textarea type="text" name="contract_working_areas" class="form-control mt-2" rows=3 required>{{$contractData2->contract_working_areas}}</textarea>
        </div>
        @error('contract_working_areas')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    @if(str_contains($contractType,'NEC4'))
    <li class="mb-3" id="key-peoples">The <i>Key Persons</i> are</li>
    @else
    <li class="mb-3" id="key-peoples">The <i>Key People</i> are</li>
    @endif
    <div class="col-12 text-end mb-3">
        <button type="button" id="btn_key_people_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add More
        </button>
    </div>
    <li class="mb-3">The following matters will be included in the {{str_contains($contractType,'NEC4') ? 'Early Warning' : 'Risk' }} Register</li>
    <textarea name="risk_register" class="form-control mt-2" rows="3" required>{{$contractData2->risk_register}}</textarea>
    @error('risk_register')
    <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
</ul>
<ul class="mb-4">
    @if(str_contains($contractType,'NEC4'))<h4 class="card-title mt-4 mb-3">The {{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}}’s main responsibilities</h4>@endif
    <p class="mt-3">If the <i>{{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}}</i> is to provide {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} @if(str_contains($contractType,'NEC4')) Scope for its @else {{str_contains($contractType,'TSC') ? 'Service' : 'Works'}} Information for his @endif {{str_contains($contractType,'TSC')?'plan':'design'}}</p>
    <li class="mb-3">The <i>@if(str_contains($contractType,'ECS')) Subcontract @endif </i> @if(str_contains($contractType,'NEC4')) Scope provided by the <i>{{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}} </i> for its @else Works Information for the <i>Subcontractor</i>'s @endif {{str_contains($contractType,'TSC')?'plan':'design'}} is in
        <textarea name="contractor_wi1" class="form-control mt-2" rows="3">{{$contractData2->contractor_wi1}}</textarea>
        @error('contractor_wi1')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @if(str_contains($contractType,'NEC4'))
    <h4 class="card-title mt-4 mb-3">Time</h4>
    @endif
    <p class="mt-3">If a {{str_contains($contractType,'TSC') ? 'plan': 'programme'}} is to be identified in the {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} Data</p>
    <li class="mb-3">The {{str_contains($contractType,'TSC') ? 'plan': 'programme'}} identified in the {{str_contains($contractType,'ECS') ? 'Subcontract' : 'Contract'}} Data is
        <textarea name="contractor_ident_plan" class="form-control mt-2" rows="3">{{$contractData2->contractor_ident_plan}}</textarea>
        @error('contractor_ident_plan')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>

    @if(!str_contains($contractType,'TSC'))
    <p class="mt-3">If the <i>{{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}}</i> is to decide the <i>completion date</i> for the whole of the <i>{{str_contains($contractType,'ECS') ? 'subcontract' : 'contract'}} works</i></p>
    <li class="mb-3"> The {{str_contains($contractType,'ECS') ? 'subcontract' : 'contract'}} <i>completion date</i> for the whole of the <i>{{str_contains($contractType,'ECS') ? 'subcontract' : 'contract'}} works</i> is
        <input type="date" name="completion_date_works" class="form-control mt-2" rows="3" value="{{$contractData2->completion_date_works}}">
        @error('completion_date_works')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
</ul>
<hr>
<ul class="mt-3 mb-4">
    @if(str_contains($contractType,'NEC4'))
    <h4 class="card-title mt-4 mb-3">Payment</h4>
    @endif

    @if(str_contains($contractType,'TSC'))

    @if(str_starts_with($contractAppl->main_opt,"Option A:") || str_starts_with($contractAppl->main_opt , "Option C:") || str_starts_with($contractAppl->main_opt ,"Option E:"))
    <p class="mt-3">If Option A ,C or E is used</p>
    <div class="" id="price-list">
        <h4 class="card-title text-center">Price List</label>
        </h4>
        <div class="">
            <div class="row mt-3 mb-2">
                <div class="col-md-4">
                    <label class="form-label">Item</label>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Qty</label>
                </div>
                <div class="col-md-1">
                    <label class="form-label">Unit</label>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Rate £</label>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Price £</label>
                </div>
                <div class="col">
                    <label class="form-label" style="text-align: center;"></label>
                </div>
            </div>
            <div id="price-lists-container"></div>
            <div class="row mb-1">
                <div class="col-7 col-md-8">
                    <button type="button" id="btn_remeasurable_pricelist_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Remeasurable Row</button>
                    <button type="button" id="btn_lumpsum_pricelist_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Lumpsum Row</button>
                </div>
                <div class="col-2 px-1  text-end">
                    <label class="form-label" style="padding-top: 10px;">Net £</label>
                </div>
                <div class="col-3 col-md-2 px-1 ">
                    <x-form.input name="net_total" readonly />
                </div>
            </div>
        </div>
    </div>
    @endif

    @else

    @if(str_starts_with($contractAppl->main_opt , "Option A:") || str_starts_with($contractAppl->main_opt ,"Option C:"))
    <p class="mt-3">If Option A or C is used</p>
    <div class="" id="activity-schedule">
        <h4 class="card-title text-center">Activity Schedule</label>
        </h4>
        <div class="">
            <div class="row mt-3 mb-2">
                <div class="col-md-1">
                    <label class="form-label">#</label>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                </div>
                <div class="col-md-1">
                    <label class="form-label">unit</label>
                </div>
                <div class="col-md-1">
                    <label class="form-label">price</label>
                </div>

                <div class="col-md-1">
                    <label class="form-label" style="text-align: center;"></label>
                </div>
            </div>
            <div id="activity-schedule-container"></div>
            <div class="row mb-1">
                <div class="col-7 col-md-8">
                    <button type="button" id="btn_activity_schedule_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                </div>
                <div class="col-2 px-1  text-end">
                    <label class="form-label" style="padding-top: 10px;">Net £</label>
                </div>
                <div class="col-3 col-md-2 px-1 ">
                    <x-form.input id="sum_total" name="sum_total" readonly />
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(str_starts_with($contractAppl->main_opt , "Option B:") || str_starts_with($contractAppl->main_opt ,"Option D:"))
    <p class="mt-3">If Option B or D is used</p>
    <div class="" id="bill-of-quantities">
        <h4 class="card-title text-center">Bill of Quantities</label>
        </h4>
        <div class="">
            <div class="row mt-3 mb-2">
                <div class="col-md-4">
                    <label class="form-label">Item</label>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Qty</label>
                </div>
                <div class="col-md-1">
                    <label class="form-label">Unit</label>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Rate £</label>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Price £</label>
                </div>
                <div class="col">
                    <label class="form-label" style="text-align: center;"></label>
                </div>
            </div>
            <div id="bill-of-quantities-schedule-container"></div>
            <div class="row mb-1">
                <div class="col-7 col-md-8">
                    <button type="button" id="btn_boq_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                </div>
                <div class="col-2 px-1  text-end">
                    <label class="form-label" style="padding-top: 10px;">Net £</label>
                </div>
                <div class="col-3 col-md-2 px-1 ">
                    <x-form.input name="net_total" readonly />
                </div>
            </div>
        </div>
    </div>
    @endif

    @endif

    @if(in_array(explode(':', $contractAppl->main_opt)[0], ['Option A', 'Option B', 'Option C', 'Option D']))
    {{--@if(!(str_starts_with($contractAppl->main_opt, 'Option E:') || str_starts_with($contractAppl->main_opt, 'Option F:')))--}}
    <p class="mt-3">If Option A {{str_contains($contractType,'TSC') ? 'or C' : ', B, C or D'}} is used</p>
    <li class="mb-3">The tendered total of the Prices is
        <input class="form-control mt-2" type="number" min=0 step=0.01 name="total_prices" style="width: 100px;" value="{{$contractData2->total_prices}}" required>
        @error('total_prices')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif

    @if(str_contains($contractType,'NEC4'))
    <h4 class="card-title mt-4 mb-3"> Resolving and avoiding disputes</h4>
    <li id="senior-representative-sect"> The <i>senior representatives</i> of the <i>{{str_contains($contractType,'ECS')?'Subcontractor':'Contractor'}}</i> are</li>
    <div class="col-12 text-end">
        <button type="button" id="btn_senior_rep_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add More
        </button>
    </div>

    @if($contractAppl->sec_opt_X10)
    <h4 class="card-title mt-4 mb-3"> X10: Information modelling</h4>
    <p class="mt-3">If Option X10 is used</p>
    <p>If an <i>information execution plan </i> is to be identified in the {{str_contains($contractType,'ECS')?'Subcontract':'Contract'}} Data</p>
    <li class="mb-3">The <i>information execution plan </i> identified in the {{str_contains($contractType,'ECS')?'Subcontract':'Contract'}} Data is
        <textarea name="x10_info_execution_plan" class="form-control mt-2" rows="3">{{$nec4ContractData2->x10_info_execution_plan}}</textarea>
        @error('x10_info_execution_plan')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif

    @if($contractAppl->sec_opt_yUK1)
    @if(str_contains($contractType,'NEC4'))
    <h4s class="card-title mt-4 mb-3">Y(UK)1: Project Bank Account</h4s>
    @endif
    <p class="mt-3">If Option Y(UK)1 is used</p>
    @if(!str_contains($contractType,'ECS'))
    <li class="mb-3">The <i>project bank</i> is
        <textarea name="project_bank" class="form-control mt-2" rows="3" required>{{$contractData2->project_bank}}</textarea>
        @error('project_bank')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    <li class="mb-3">The <i>named suppliers</i> are
        <textarea name="named_suppliers" class="form-control mt-2" rows="3" required>{{$contractData2->named_suppliers}}</textarea>
        @error('named_suppliers')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    @endif


</ul>