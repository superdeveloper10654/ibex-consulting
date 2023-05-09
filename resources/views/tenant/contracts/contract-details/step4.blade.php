<ul class="mb-4">
    <li class="mb-2">The @if(str_contains($contractType,'ECS')) Subcontract @endif @if(str_contains($contractType,'NEC4')) Scope @else {{str_contains($contractType,'TSC') ? 'Service':'Works'}} Information @endif is in
        <textarea name="works_information_is_in" class="form-control mt-2 mb-3" rows="3" required>{{$contractAppl->works_information_is_in}}</textarea>
        @error('works_information_is_in')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
  </li>
      <p class="text-muted mt-3 mb-4"><i class="bx bx-info-circle ms-1"></i>
                                <small>
                                    Enter the @if(str_contains($contractType,'ECS')) Subcontract @endif @if(str_contains($contractType,'NEC4')) Scope @else {{str_contains($contractType,'TSC') ? 'Service':'Works'}} Information @endif in the field above, or use the suggested fields below
                                </small>
                            </p>
        
            <li class="mb-2">The @if(str_contains($contractType,'ECS')) Subcontract @endif @if(str_contains($contractType,'NEC4')) Scope @else {{str_contains($contractType,'TSC') ? 'Service':'Works'}} Information @endif is
            <div class="mb-3 print-no-break">
                <div class="works_or_service mt-3 mb-2">W 100: Description of the {{str_contains($contractType,'NEC4') ? 'Scope' : 'Works'}}</div>
                <textarea name="wi100" class="form-control" rows="3" required>{{$contractAppl->subcontract_works_are}}</textarea>
                @error('wi100')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="works_or_service mb-2">W 200: General constraints on how the {{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}} provides the {{str_contains($contractType,'NEC4') ? 'Scope' : 'Works'}}</div>
                <textarea name="wi200" class="form-control" rows="3" required>{{$contractAppl->wi200}}</textarea>
                @error('wi200')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 300: {{str_contains($contractType,'ECS') ? 'Subcontractor' : 'Contractor'}}'s Design</div>
                <textarea name="wi300" class="form-control" rows="3" required>{{$contractAppl->wi300}}</textarea>
                @error('wi300')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 400: Completion</div>
                <textarea name="wi400" class="form-control" rows="3" required>{{$contractAppl->wi400}}</textarea>
                @error('wi400')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 500: Programme</div>
                <textarea name="wi500" class="form-control" rows="3" required>{{$contractAppl->wi500}}</textarea>
                @error('wi500')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 600: Quality assurance</div>
                <textarea name="wi600" class="form-control" rows="3" required>{{$contractAppl->wi600}}</textarea>
                @error('wi600')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 700: Tests and inspections</div>
                <textarea name="wi700" class="form-control" rows="3" required>{{$contractAppl->wi700}}</textarea>
                @error('wi700')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="works_or_service mb-2">W 800: Management of the {{str_contains($contractType,'NEC4') ? 'Scope' : 'Works'}}</div>
                <textarea name="wi800" class="form-control" rows="3" required>{{$contractAppl->wi800}}</textarea>
                @error('wi800')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 900: Working with the {{str_contains($contractType,'NEC4') ? 'Client' : 'Empployer'}} and others</div>
                <textarea name="wi900" class="form-control" rows="3" required>{{$contractAppl->wi900}}</textarea>
                @error('wi900')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 1000: Services and other things to be provided</div>
                <textarea name="wi1000" class="form-control" rows="3" required>{{$contractAppl->wi1000}}</textarea>
                @error('wi1000')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 1100: Health and safety</div>
                <textarea name="wi1100" class="form-control" rows="3" required>{{$contractAppl->wi1100}}</textarea>
                @error('wi1100')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 1200: Subcontracting</div>
                <textarea name="wi1200" class="form-control" rows="3" required>{{$contractAppl->wi1200}}</textarea>
                @error('wi1200')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 1300: Title</div>
                <textarea name="wi1300" class="form-control" rows="3" required>{{$contractAppl->wi1300}}</textarea>
                @error('wi1300')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 print-no-break">
                <div class="mb-2">W 2000: {{str_contains($contractType,'NEC4') ? 'Client' : 'Employer'}}'s work specifications and drawings</div>
                <textarea name="wi2000" class="form-control" rows="3" required>{{$contractAppl->wi2000}}</textarea>
                @error('wi2000')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
        
    </li>
    @if($contractType==='NEC4_TSC')
    <li class="mb-4">The <i>shared services</i> which may be carried out outside the Service Areas are
        <textarea name="outside_works_information" class="form-control mt-2 mb-3" rows="3" required>{{$nec4Contract->outside_works_information}}</textarea>
        @error('outside_works_information')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    @if(!str_contains($contractType,'TSC'))
    <li class="mt-3 mb-3">The Site Information is in
        <textarea name="site_information_is_in" class="form-control mt-2" rows="3" required>{{$contractAppl->site_information_is_in}}</textarea>
        @error('site_information_is_in')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mt-3 mb-3">The <i>boundaries of the site</i> are
        <textarea name="boundaries_are" class="form-control mt-2" rows="3" required>{{$contractAppl->boundaries_are}}</textarea>
        @error('boundaries_are')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    <li class="mb-3">The <i>language of this {{str_contains($contractType,'ECS') ? 'sub':''}}contract </i> is
        <input type="text" name="language_is" class="form-control mt-2" placeholder="English." value="{{$contractAppl->language_is}}" required>
        @error('language_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>law of the {{str_contains($contractType,'ECS') ? 'sub':''}}contract</i> is the law of
        <input type="text" name="law_is" class="form-control mt-2" placeholder="England and Wales." value="{{$contractAppl->law_is}}" required>
        @error('law_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>period for reply</i> is
        <div class="input-group mt-2">
            @if (str_contains($contractType,'ECS'))
            <label class="input-group-text mt-2"> for a reply by the <i>&nbsp; Contractor &nbsp;</i> is </label>
            @endif
            <input name="period_for_reply_is" min=0 type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->period_for_reply_is}}" required>
            <label class="input-group-text mt-2">weeks</label>
        </div>
        @error('period_for_reply_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        @if (str_contains($contractType,'NEC4'))
        <div class="mt-2 mb-4" id="except-reply-periods">except that
        </div>
        <div class="my-2 d-flex justify-content-end col">
            <button type="button" id="btn_add_except_reply_period" class="btn btn-sm btn-light"><i class="mdi mdi-plus me-1"></i><small>Add Row</small></button>
        </div>
        @endif
        @if (str_contains($contractType,'ECS'))
        <div class="input-group mt-2">
            <label class="input-group-text mt-2"> for a reply by the <i>&nbsp; Subcontractor &nbsp;</i> is </label>
            <input name="subcontractor_period_for_reply_is" type="number" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$contractAppl->subcontractor_period_for_reply_is}}" required>
            <label class="input-group-text mt-2">weeks</label>
        </div>
        @error('subcontractor_period_for_reply_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
        @if (str_contains($contractType,'NEC4'))
        <div class="mt-2 mb-4" id="sub-except-reply-periods"> except that
        </div>
        <div class="my-2 d-flex justify-content-end col">
          <button type="button" id="btn_add_sub_except_reply_period" class="btn btn-sm btn-light "><i class="mdi mdi-plus me-1"></i><small>Add Row</small></button>
        </div>
        @endif
        @endif
    </li>
    @if (!str_contains($contractType,'NEC4'))
    <li class="mb-3">The <i>Adjudicator nominating body</i> is
        <input type="text" name="adjudicator_body_is" class="form-control mt-2" value="{{$contractAppl->adjudicator_body_is}}" required>
        @error('adjudicator_body_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    <li class="mb-3">The <i>tribunal</i> is
        <input type="text" name="tribunal_is" class="form-control mt-2" value="{{$contractAppl->tribunal_is}}" required>
        @error('tribunal_is')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
    <li class="mb-3">The following matters will be included in the {{str_contains($contractType,'NEC4')?'Early Warning':'Risk'}} Register
        <textarea name="risk_register_matters_are" class="form-control mt-2" rows="3" required>{{$contractAppl->risk_register_matters_are}}</textarea>
        @error('risk_register_matters_are')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @if (str_contains($contractType,'NEC4'))
    <li class="mb-3">Early warning meetings are to be held at intervals no longer than
      <div class="input-group mt-2">
                        <input type="number" min=0 name="early_warnings_no_longer_than" class="form-control mt-2" style="flex: inherit; width: 100px;" value="{{$nec4Contract->early_warnings_no_longer_than}}" required>
            <label class="input-group-text mt-2">weeks</label>
        </div>
      @error('early_warnings_no_longer_than')
        <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </li>
    @endif
</ul>