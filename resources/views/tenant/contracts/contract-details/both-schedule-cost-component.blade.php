@if(!str_contains($contractType,'NEC4') && (str_starts_with($contractAppl->main_opt , "Option C:") || str_starts_with($contractAppl->main_opt , "Option D:") || str_starts_with($contractAppl->main_opt , "Option E:")))
<h5 class="mt-5">Data for Both Schedule of Cost Components </h5>
<h6 class="mt-3">If Option C @if(!str_contains($contractType,'TSC')) , D @endif or E is used</h6>
@endif

@if(!str_contains($contractType,'NEC4_TSC'))
<li class="mb-3">The @if(!str_contains($contractType,'NEC4')) hourly @endif rates for Defined Cost of design outside the Working Areas are
    <div class="row mt-2">
        <div class="col-md-9">
            <h6>category of {{str_contains($contractType,'NEC4') ? 'person' : 'employee'}}</h6>
        </div>
        <div class="col-md-2">
            <h6>@if(!str_contains($contractType,'NEC4')) hourly @endif rate</h6>
        </div>
    </div>
    <div id="design-defined-costs"></div>
    <div class="col-md-12 text-end">
        <button type="button" id="btn_design_defined_cost_add" class="btn btn-sm btn-primary my-2"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
    </div>
</li>
@endif

@if(!str_contains($contractType,'NEC4'))
<li class="mb-3">The percentage for design overheads is
    <div class="input-group mt-2">
        <div class="input-group-prepend">
            <input class="form-control" type="number" min=0 step=0.01 name="design_oh_percent" style="width: 100px;" value="{{$contractData2->design_oh_percent}}" required>
        </div>
        <label class="input-group-text">%</label>
    </div>
    @error('design_oh_percent')
    <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
</li>
@endif

@if(!str_contains($contractType,'NEC4_TSC'))
<li class="mb-3">The categories of design {{str_contains($contractType,'NEC4') ? 'people' : 'employees'}} whose travelling expenses to and from the Working Areas are included
    @if(str_starts_with($contractAppl->main_opt , "Option A:") || str_starts_with($contractAppl->main_opt , "Option B:")) in Defined Cost @else as a cost of design of the <i>@if($contractType=='ECS') subcontract @endif works</i> and Equipment done outside the Working Areas @endif are
    <textarea name="design_expenses_cats" class="form-control mt-2" rows="3" required>{{$contractData2->design_expenses_cats}}</textarea>
    @error('design_expenses_cats')
    <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
</li>
@endif