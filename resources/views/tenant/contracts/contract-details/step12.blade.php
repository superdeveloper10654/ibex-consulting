@if(
(str_contains($contractType,'ECC') && ($contractAppl->main_opt==="Option A: Priced contract with Activity Schedule"||$contractAppl->main_opt==="Option C: Target contract with Activity Schedule") )
||
(str_contains($contractType,'ECS') && ($contractAppl->main_opt==="Option A: Priced subcontract with Activity Schedule"||$contractAppl->main_opt==="Option C: Target subcontract with Activity Schedule") )
)
<div class="card print-no-break">
    <div class="card-body" id="activity-schedule">
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
                <div class="col-2 px-1 text-end">
                    <label class="form-label" style="padding-top: 10px;">Net £</label>
                </div>
                <div class="col-3 col-md-2 px-1 ">
                    <x-form.input id="sum_total" name="sum_total" readonly />
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if(
(str_contains($contractType,'ECC') && ($contractAppl->main_opt==="Option B: Priced contract with Bill of Quantities"||$contractAppl->main_opt==="Option D: Target contract with Bill of Quantities") )
||
(str_contains($contractType,'ECS') && ($contractAppl->main_opt==="Option B: Priced subcontract with Bill of Quantities"||$contractAppl->main_opt==="Option D: Target subcontract with Bill of Quantities") )
)
<div class="card">
    <div class="card-body" id="bill-of-quantities">
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
</div>
@endif
@if(($contractType==='TSC'||$contractType==="NEC4_TSC") && ($contractAppl->main_opt==="Option A: Priced contract with Activity Schedule"||$contractAppl->main_opt==="Option C: Priced contract with Bill of Quantities") )
<div class="card">
    <div class="card-body" id="price-list">
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
</div>
@endif