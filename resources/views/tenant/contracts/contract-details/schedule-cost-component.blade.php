@if(!(str_contains($contractType,'NEC4') && (str_starts_with($contractAppl->main_opt,'Option A') || str_starts_with($contractAppl->main_opt,'Option B'))))
<!-- not for nec 3 a,b -->
<li class="mb-3">The listed items of Equipment purchased for work on this {{$contractType == 'ECS' ? 'sub':''}}contract, with an on cost charge, are
    <div class="row mt-2">
        <div class="col-md-5">
            <h6>Equipment</h6>
        </div>
        <div class="col-md-3">
            <h6>time-related charge</h6>
        </div>
        <div class="col-md-3">
            <h6>per time period</h6>
        </div>
    </div>
    <div id="time-equipments"></div>
    <div class="col-md-12 text-end">
        <button type="button" id="btn_time_equipment_add" class="btn btn-sm btn-primary my-2"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
</li>

<li class="mb-3">The rates for special Equipments are
    <div class="row mt-2">
        @if(str_contains($contractType,'NEC4'))
        <div class="col-md-9">
            <h6>Equipment</h6>
        </div>

        <div class="col-md-2">
            <h6>rate</h6>
        </div>
        @else
        <div class="col-md-5">
            <h6>Equipment</h6>
        </div>
        <div class="col-md-4">
            <h6>size or capacity</h6>
        </div>
        <div class="col-md-2">
            <h6>rate</h6>
        </div>
        @endif
    </div>
    <div id="special-equipments"></div>
    <div class="col-md-12 text-end">
        <button type="button" id="btn_special_equipment_add" class="btn btn-sm btn-primary my-2"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
</li>
@endif

@if($contractType=='ECS'||$contractType=='ECC')
<li class="mb-3">The percentage for Working Areas overheads is
    <div class="input-group mt-2">
        <div class="input-group-prepend">
            <input class="form-control" type="number" min=0 step=0.01 name="percent_work_area_oh" style="width: 100px;" value="{{$contractData2->percent_work_area_oh}}" required>
        </div>
        <label class="input-group-text">%</label>
    </div>
    @error('percent_work_area_oh')
    <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
</li>
@endif

<li class="mb-3">
    The @if(!str_contains($contractType,'NEC4')) hourly @endif rates for Defined Cost of manufacture and fabrication outside the {{str_contains($contractType,'TSC') ? 'Service' : 'Workings'}} Areas @if(str_contains($contractType,'NEC4')) by the <i>{{str_contains($contractType,'ECS') ? 'Subcontactor' : 'Contractor'}}</i> @endif are
    <div class="row mt-2">
        <div class="col-md-9">
            <h6>category of {{str_contains($contractType,'NEC4') ? 'person' : 'employee'}}</h6>
        </div>
        <div class="col-md-2">
            <h6>@if(!str_contains($contractType,'NEC4')) hourly @endif rate</h6>
        </div>
    </div>
    <div id="manufact_fab-defined-costs"></div>
    <div class="col-md-12 text-end">
        <button type="button" id="btn_manufact_fab_defined_cost_add" class="btn btn-sm btn-primary my-2"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
</li>

@if($contractType=='ECS'||$contractType=='ECC')
<li class="mb-3"> The percentage for manufacture and fabrication overheads is
    <div class="input-group mt-2">
        <div class="input-group-prepend">
            <input class="form-control" type="number" min=0 step=0.01 name="manufacture_fab_oh" style="width: 100px;" value="{{$contractData2->manufacture_fab_oh}}" required>
        </div>
        <label class="input-group-text">%</label>
    </div>
    @error('manufacture_fab_oh')
    <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
</li>
@endif

@if($contractType=='NEC4_TSC')
<li>The rate for people providing <i>shared services</i> outside the Service Areas are
    <div class="row mt-2">
        <div class="col-md-5">
            <h6>shared service</h6>
        </div>
        <div class="col-md-4">
            <h6>category of person</h6>
        </div>
        <div class="col-md-2">
            <h6>rate</h6>
        </div>
    </div>
    <div id="shared-defined-costs"></div>
    <div class="col-md-12 text-end">
        <button type="button" id="btn_shared_defined_cost_add" class="btn btn-sm btn-primary my-2"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
</li>
@endif