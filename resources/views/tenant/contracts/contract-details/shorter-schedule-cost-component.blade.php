@if((str_starts_with($contractAppl->main_opt , "Option C:") || str_starts_with($contractAppl->main_opt , "Option D:") || str_starts_with($contractAppl->main_opt , "Option E:")))
<h5 class="mt-5">Data for the Shorter Schedule of Cost Components</h5>
<h6 class="mt-3">If Option C, D or E is used</h6>
@endif

@if(str_contains($contractType,'NEC4'))
<li>The <i>people rates</i> are
    <div class="row mt-2">
        <div class="col-md-7">
            <h6>category of person</h6>
        </div>
        <div class="col-md-2">
            <h6>unit</h6>
        </div>
        <div class="col-md-2" style="padding-left: 0;">
            <h6>rate</h6>
        </div>
    </div>
    <div id="other-defined-costs"></div>
    <div class="col-md-12 text-end">
        <button type="button" id="btn_other_defined_cost_add" class="btn btn-sm btn-primary my-2"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
</li>
@else
<li class="mb-3">The percentage for people overheads is
    <div class="input-group mt-2">
        <div class="input-group-prepend">
            <input class="form-control" type="number" min=0 step=0.01 name="people_oh_percent" style="width: 100px;" value="{{$contractData2->people_oh_percent}}" required>
        </div>
        <label class="input-group-text">%</label>
    </div>
    @error('people_oh_percent')
    <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
</li>
@endif

<li class="mb-3">The published list of Equipment is the @if(str_contains($contractType,'NEC4')) edition current at the @if(str_contains($contractType,'ECS')) Subcontract @else Contract @endif Date @else last edition @endif of the list published by
    <input class="form-control mt-2" type="text" name="equipment_publisher" value="{{$contractData2->equipment_publisher}}" required>
    @error('equipment_publisher')
    <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
</li>

<li class="mb-3">The percentage adjustment for Equipment in the published list is
    <div class="input-group mt-2">
        <input class="form-control" type="number" step=0.01 name="equipment_adj" style="width: 100px; flex: none;" value="{{$contractData2->equipment_adj}}" required>
        <label class="input-group-text">% (state plus or minus) </label>
    </div>
    @error('equipment_adj')
    <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
</li>

<li class="mb-3">The rates for other Equipment are
    <div class="row mt-2">
        @if($contractType=='NEC4_ECS')
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
    <div id="other-equipments"></div>
    <div class="col-md-12 text-end">
        <button type="button" id="btn_other_equipment_add" class="btn btn-sm btn-primary my-2"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
</li>