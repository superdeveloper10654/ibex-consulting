<div class="row">
    <div class="mb-3 print-no-break">
        <label class="form-label">Main Option</label>
        <select name="main_opt" id="main_option" class="form-select" required>
            <option value="">Select</option>
            @if(str_contains($contractType,'ECC'))
            <option id="ecc-opt-a" value="Option A: Priced contract with Activity Schedule" {{str_starts_with($contractAppl->main_opt, "Option A") ? 'selected':''}}>Option A: Priced contract with Activity Schedule</option>
            <option id="ecc-opt-b" value="Option B: Priced contract with Bill of Quantities" {{str_starts_with($contractAppl->main_opt, "Option B") ? 'selected':''}}>Option B: Priced contract with Bill of Quantities</option>
            <option id="ecc-opt-c" value="Option C: Target contract with Activity Schedule" {{str_starts_with($contractAppl->main_opt, "Option C") ? 'selected':''}}>Option C: Target contract with Activity Schedule</option>
            <option id="ecc-opt-d" value="Option D: Target contract with Bill of Quantities" {{str_starts_with($contractAppl->main_opt, "Option D") ? 'selected':''}}>Option D: Target contract with Bill of Quantities</option>
            <option id="ecc-opt-e" value="Option E: Cost reimbursable contract" {{str_starts_with($contractAppl->main_opt, "Option E") ? 'selected':''}}>Option E: Cost reimbursable contract</option>
            <option id="ecc-opt-f" value="Option F: Management contract" {{str_starts_with($contractAppl->main_opt, "Option F") ? 'selected':''}}>Option F: Management contract</option>
            @endif
            @if(str_contains($contractType,'ECS'))
            <option id="ecs-opt-a" value="Option A: Priced subcontract with Activity Schedule" {{str_starts_with($contractAppl->main_opt, "Option A") ? 'selected':''}}>Option A: Priced subcontract with Activity Schedule</option>
            <option id="ecs-opt-b" value="Option B: Priced subcontract with Bill of Quantities" {{str_starts_with($contractAppl->main_opt, "Option B") ? 'selected':''}}>Option B: Priced subcontract with Bill of Quantities</option>
            <option id="ecs-opt-c" value="Option C: Target subcontract with Activity Schedule" {{str_starts_with($contractAppl->main_opt, "Option C") ? 'selected':''}}>Option C: Target subcontract with Activity Schedule</option>
            <option id="ecs-opt-d" value="Option D: Target subcontract with Bill of Quantities" {{str_starts_with($contractAppl->main_opt, "Option D") ? 'selected':''}}>Option D: Target subcontract with Bill of Quantities</option>
            <option id="ecs-opt-e" value="Option E: Cost reimbursable subcontract" {{str_starts_with($contractAppl->main_opt, "Option E") ? 'selected':''}}>Option E: Cost reimbursable subcontract</option>
            @endif
            @if(str_contains($contractType,'TSC'))
            <option id="tsc-opt-a" value="Option A: Priced contract with Activity Schedule" {{str_starts_with($contractAppl->main_opt, "Option A") ? 'selected':''}}>Option A: Priced contract with Price List</option>
            <option id="tsc-opt-c" value="Option C: Priced contract with Bill of Quantities" {{str_starts_with($contractAppl->main_opt, "Option C") ? 'selected':''}}>Option C: Priced contract with Bill of Quantities</option>
            <option id="tsc-opt-e" value="Option E: Cost reimbursable contract" {{str_starts_with($contractAppl->main_opt, "Option E") ? 'selected':''}}>Option E: Cost reimbursable contract</option>
            @endif
        </select>
        @error('main_opt')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>
</div>
<div class="row">
    <div class="mb-3 print-no-break">
        <label class="form-label">Dispute Resolution Option</label>
        <select name="resolution_opt" id="dispute_resolution_option" class="form-select" required>
            <option value="">Select</option>
            <option id="w1" value="W1 (consensual adjudication outside the Construction Act)" {{$contractAppl->resolution_opt === "W1 (consensual adjudication outside the Construction Act)" ? 'selected':''}}>W1 (consensual adjudication outside the Construction Act)</option>
            <option id="w2" value="W2 (mandatory adjudication as prescribed in the Construction Act)" {{$contractAppl->resolution_opt === "W2 (mandatory adjudication as prescribed in the Construction Act)" ? 'selected':''}}>W2 (mandatory adjudication as prescribed in the Construction Act)</option>
        </select>
        @error('resolution_opt')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <div class="print-no-break">
            <label class="form-label">Secondary Options</label>
            <div class="row pt-2 print-no-break" id="row-x1">
                <input type="checkbox" name="x1" class="customized secondary-option" {{$contractAppl->sec_opt_X1 == 1 ? 'checked':''}} />
                <label style="width: calc(100% - 100px); font-weight: 400;">X1: Price adjustment for inflation</label>
            </div>
        </div>
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="x2" class="customized secondary-option" {{$contractAppl->sec_opt_X2 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X2: Changes in the law</label>
        </div>
        <div class="row pt-2 print-no-break" id="row-x3">
            <input type="checkbox" name="x3" class="customized secondary-option" {{$contractAppl->sec_opt_X3 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X3: Multiple currencies</label>
        </div>
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="x4" class="customized secondary-option" {{$contractAppl->sec_opt_X4 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X4: Parent company guarantee</label>
        </div>
        @if(!str_contains($contractType,'TSC'))
        <div class="row pt-2 print-no-break" id="row-x5">
            <input type="checkbox" name="x5" class="customized secondary-option" {{$contractAppl->sec_opt_X5 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X5: Sectional Completion</label>
        </div>
        <div class="row pt-2 print-no-break" id="row-x6">
            <input type="checkbox" name="x6" class="customized secondary-option" {{$contractAppl->sec_opt_X6 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X6: Bonus for early Completion</label>
        </div>
        <div class="row pt-2 print-no-break" id="row-x7">
            <input type="checkbox" name="x7" class="customized secondary-option" {{$contractAppl->sec_opt_X7 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X7: Delay damages</label>
        </div>
        @endif
        @if(str_contains($contractType,'NEC4'))
        <div class="row pt-2 print-no-break" id="row-x8">
            <input type="checkbox" name="x8" class="customized secondary-option" {{$contractAppl->sec_opt_X8 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X8: Undertakings to the <i>Client</i> or Others</label>
        </div>
        <div class="row pt-2 print-no-break" id="row-x10">
            <input type="checkbox" name="x10" class="customized secondary-option" {{$contractAppl->sec_opt_X10 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X10: Information modelling</label>
        </div>
        @endif
        <div class="row pt-2 print-no-break" id="row-x12">
            <input type="checkbox" name="x12" class="customized secondary-option" {{$contractAppl->sec_opt_X12 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X12: Partnering</label>
        </div>
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="x13" class="customized secondary-option" {{$contractAppl->sec_opt_X13 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X13: Performance bond</label>
        </div>
        @if(!str_contains($contractType,'TSC'))
        <div class="row pt-2 print-no-break" id="row-x14">
            <input type="checkbox" name="x14" class="customized secondary-option" {{$contractAppl->sec_opt_X14 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X14: Advanced payment to the Contractor</label>
        </div>
        <div class="row pt-2 print-no-break" id="row-x15">
            <input type="checkbox" name="x15" class="customized secondary-option" {{$contractAppl->sec_opt_X15 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X15: Limitation of the Contractor's Design</label>
        </div>
        <div class="row pt-2 print-no-break" id="row-x16">
            <input type="checkbox" name="x16" class="customized secondary-option" {{$contractAppl->sec_opt_X16 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X16: Retention</label>
        </div>
        @endif
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="x17" class="customized secondary-option" {{$contractAppl->sec_opt_X17 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X17: Low performance damages</label>
        </div>
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="x18" class="customized secondary-option" {{$contractAppl->sec_opt_X18 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X18: Limitation of liability</label>
        </div>
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="x19" class="customized secondary-option" {{$contractAppl->sec_opt_X19 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X19: Task Order</label>
        </div>
        <div class="row pt-2 print-no-break" id="row-x20">
            <input type="checkbox" name="x20" class="customized secondary-option" {{$contractAppl->sec_opt_X20 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X20: Key Performance Indicators</label>
        </div>
        @if($contractType=='NEC4_TSC')
        <div class="row pt-2 print-no-break" id="row-x23">
            <input type="checkbox" name="x23" class="customized secondary-option" {{$contractAppl->sec_opt_X23 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X23: Extending the Service Period</label>
        </div>
        <div class="row pt-2 print-no-break" id="row-x24">
            <input type="checkbox" name="x24" class="customized secondary-option" {{$contractAppl->sec_opt_X24 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">X24: The <i>accounting periods</i></label>
        </div>
        @endif
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="yUK1" class="customized secondary-option" {{$contractAppl->sec_opt_yUK1 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">Y(UK)1: contract Bank Account</label>
        </div>
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="yUK2" class="customized secondary-option" {{$contractAppl->sec_opt_yUK2 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">Y(UK)2: The Housing Grants, Construction and Regeneration Act 1996</label>
        </div>
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="yUK3" class="customized secondary-option" {{$contractAppl->sec_opt_yUK3 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">Y(UK)3: The Contract (Rights of Third Parties) Act 1999</label>
        </div>
        <div class="row pt-2 print-no-break">
            <input type="checkbox" name="z1" class="customized secondary-option" {{$contractAppl->sec_opt_Z1 == 1 ? 'checked':''}} />
            <label style="width: calc(100% - 100px); font-weight: 400;">Z1: additional conditions of Contract</label>
        </div>
    </div>
</div>